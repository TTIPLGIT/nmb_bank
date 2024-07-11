<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Psy\Readline\Hoa\Console;

class ValuerController extends BaseController
{
    public function index(Request $request)
    {  
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $method = 'Method => LoginController => Register_screen';
        $request =  array();
        $request['mlhud_id'] = $user_id;
        $gatewayURL = config('setting.api_gateway_url').'/valuer/screen';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method); 
        $response = json_decode($response);
        
        $objData = json_decode($this->decryptData($response->Data));
        $code=$objData->Code;
        
        if($code=="401"){
    
            return redirect()->route('unauthenticated')->send();
       } 
        $rows = json_decode(json_encode($objData->Data), true); 
        $menus = $this->FillMenu();
        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view('gtapprove.gt_index', compact('user_id','rows','menus','screens','modules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$id)
    {
        
    }
    public function approve(Request $request)
    {   
       
        $user_id=$request->user_id;//current user
        $valuer_id=$request->valuer_id;//valuer_id
        $v_user_id=$request->v_user_id;//valuer_user_id
        if($user_id==null){
            return view('valuer.index');
        }
        $method = 'Method => LoginController => Register_screen';
        $request =  array();
        $request['user_id'] = $user_id;
        $request['v_user_id'] = $v_user_id;
        $request['valuer_id'] = $valuer_id;
        $gatewayURL = config('setting.api_gateway_url').'/valuer/approve';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method); 
        $response = json_decode($response);
       
        $objData = json_decode($this->decryptData($response->Data)); 
         $code=$objData->Code;
        
         if($code=="401"){
     
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        
        $rows = json_decode(json_encode($objData->Data), true);   
        $menus = $this->FillMenu();
        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

    //     return view('valuers.index', compact('user_id','rows','menus','screens','modules'));
    return view('valuers.approve',compact('menus','screens','modules','rows'));
    }
    public function approve_for_stake(Request $request)
    {  
       
        $user_id=$request->user_id;
        $valuer_id=$request->valuer_id;
        if($user_id==null){
            return view('valuer.index');
        }
        $method = 'Method => LoginController => Register_screen';
        $request =  array();
        $request['user_id'] = $user_id;
        $request['valuer_id']=$valuer_id;
        $gatewayURL = config('setting.api_gateway_url').'/valuer/approve';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method); 
        $response = json_decode($response); 
        $objData = json_decode($this->decryptData($response->Data)); 
        $rows = json_decode(json_encode($objData->Data), true);   
        $menus = $this->FillMenu();
        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

    //     return view('valuers.index', compact('user_id','rows','menus','screens','modules'));
    return view('valuers.stake_approve',compact('menus','screens','modules','rows'));
    }
    public function Certificate_index(Request $request){
        $user_id=$request->session()->get("userID");
       
        $status="certificate_index";
    
        if($user_id==null){
            return view('valuer.index');
        }
        $method = 'Method => LoginController => Register_screen';
        $request =  array();
        $request['status'] = $status;
        $request['user_id'] = $user_id;
        $gatewayURL = config('setting.api_gateway_url').'/valuer/approve';
    
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method); 
       
        $response = json_decode($response); 
       
        $objData = json_decode($this->decryptData($response->Data)); 
        $rows = json_decode(json_encode($objData->Data), true);   
        $menus = $this->FillMenu();
        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

    //     return view('valuers.index', compact('user_id','rows','menus','screens','modules'));
    return view('valuers.certificate_index',compact('menus','screens','modules','rows'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
    
         $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $method = 'Method => Questionmaster => store';
        $user_details=$request->registration_status;
        
        if($user_details=="Registered")
        {    
           $data=array();
            $data['user_id'] =$user_id;
            $data['user_details']=$user_details;
            $encryptArray = $data;
                $request = array();
                $request['requestData'] = $encryptArray;
            
                $gatewayURL = config('setting.api_gateway_url').'/valuerlist/storedata';
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                
                $response1 = json_decode($response);
                if($response1->Status == 200 && $response1->Success){
                $objData = json_decode($this->decryptData($response1->Data));
                
        
                if ($objData->Code == 200) {
                    return redirect(route('home'))->with('success', 'Registration Completed Successfully');
                }
        
                if ($objData->Code == 400) {
                    return redirect(route('Registration.index'))->with('fail', 'Registration Details Already Exists');
                    }
                }
        
        
                else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);exit;                            
                }
            }
        }
        
    public function stakeholder_data(Request $request){
        try{    
        $method = 'Method => ajaxController => index';
        $gatewayURL = config('setting.api_gateway_url') . '/ajax_data/get_stake_data';   
        $this->WriteFileLog($gatewayURL);   
        $serviceResponse = array();
        $serviceResponse['dynamiclist'] = $request['id'];
        $this->WriteFileLog($serviceResponse);

        
        
        
        $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
        
        $response = $this->serviceRequest($gatewayURL, 'POST', $serviceResponse, $method);
       
        $this->WriteFileLog($response); 
        $response = json_decode($response);             
        
        
        
        if ($response->Status == 200 && $response->Success)     {
            $objData = json_decode($this->decryptData($response->Data));
           
            if ($objData->Code == 200) {
                $parant_data = json_decode(json_encode($objData->Data), true);
                $rows =  $parant_data['rows'];
                $this->WriteFileLog($rows);
                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                $permission = $this->FillScreensByUser();
                $screen_permission = $permission[0];
                
                    $this->WriteFileLog($rows);
                    return $rows;
                
                
            }
        } else {
            $objData = json_decode($this->decryptData($response->Data));
            echo json_encode($objData->Code);
            exit;
        }
    } catch (\Exception $exc) {
        echo $exc;
        return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {      
        try {
     
        $method = 'Method => UamModulesController => show';
          $id = $this->decryptData($id);
          // echo json_encode($id);exit;t
          $gatewayURL = config('setting.api_gateway_url').'/valuer/show/'.$this->encryptData($id);
          $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
          $response = json_decode($response);
          
          if($response->Status == 200 && $response->Success){
             $objData = json_decode($this->decryptData($response->Data));
             if ($objData->Code == 200) {
                $parant_data = json_decode(json_encode($objData->Data), true);
                $rows =  $parant_data['rows'];
                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                return view('valuers.show', compact('rows','screens','modules'));
             }
          }
          else {
             $objData = json_decode($this->decryptData($response->Data));
             echo json_encode($objData->Code);exit;                            
          }
       } catch(\Exception $exc){  
          return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
       }
       }
       
    
    
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approvedvaluers(Request $request){
        $user_id=$request->session()->get("userID");
        
        if($user_id==null){
            return view('auth.login');
        }
        $method = 'Method => LoginController => Register_screen';
        $request =  array();
        $request['mlhud_id'] = $user_id;
        $gatewayURL = config('setting.api_gateway_url').'/valuer/approved/screen';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method); 
        $response = json_decode($response);
        
        
        $objData = json_decode($this->decryptData($response->Data));
        $code=$objData->Code;
        
        if($code=="401"){
    
           return redirect(url('/'))->with('danger', 'User session Exipired');
       } 
        $rows = json_decode(json_encode($objData->Data), true); 
        $menus = $this->FillMenu();
        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];
       
        
        
        return view('valuers.approved_valuers', compact('user_id','rows','menus','screens','modules'));

    }
    public function approve_valuer(Request $request){
       
        $currentDateTime = now();
        $newDateTime =$currentDateTime->addMonths(12);
        $newDateTime=explode(" ",$newDateTime);
        $id=$request->id;
      
        $valuer=DB::select("select user_id from valuer_list where valuer_id=$id;");
        $valuer=$valuer[0]->user_id;
        $input=[
            'id'=>$id,
            'status'=>'approved',
            'renewal_date'=>$newDateTime[0],
            'user_id'=>$valuer

        ];
        
       
        DB::transaction(function () use ($input) {
            $role_id = DB::table('approved_valuers')
                ->insertGetId([
                    'valuer_id' => $input['id'],
                     'status'=>$input['status']

                ]);
               
            });

// Deepika
            $notifications_valuer = DB::table('notifications')->insertGetId([
                'user_id' => session()->get("userID"),
                'role_id'=>'1',
                'notification_status' => 'Valuer Approved',
                'notification_url' => 'valuerlist',
                'megcontent' => "Valuer Details Approved Successfully.",
                'alert_meg' => "Valuer Details Approved Successfully.",
                'created_by' => session()->get("userID"),
                'created_at' => NOW()
            ]);



            DB::table('user_general_details')
            ->where('user_id', $input['user_id'])
            ->update(['g_status' =>'approved']);
            DB::table('user_payment_details')
            ->where('user_id', $input['user_id'])
            ->update(['renewal_date' =>$input['renewal_date']]);
            DB::table('valuer_list')
            ->where('user_id', $input['user_id'])
            ->update(['v_status' =>'approved','s_status'=>'approved','active_flag'=>'1']);

            // $role_name=DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);
			// $role_name_fetch=$role_name[0]->role_name;
            // $this->auditLog('approved_valuers',$input['id'] , 'Approved', 'Valuer approved Details.',['id'] , NOW(), $role_name_fetch);

            
    }
    public function certificate_issue(Request $request){
            $user_id=$request->v_user_id;
            
        if($user_id==null){
            return view('valuer.index');
        }
        $method = 'Method => LoginController => Register_screen';
        $request =  array();
        $request['user_id'] = $user_id;
        $gatewayURL = config('setting.api_gateway_url').'/valuer/certification/screen';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method); 
        $response = json_decode($response); 
        $objData = json_decode($this->decryptData($response->Data)); 
        $rows = json_decode(json_encode($objData->Data), true);   
        $menus = $this->FillMenu();
        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

    //     return view('valuers.index', compact('user_id','rows','menus','screens','modules'));
    return view('valuers.certificate_issue',compact('menus','screens','modules','rows'));
    }
    public function user_certify(Request $request){
        
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $method = 'Method => Questionmaster => store';
        $v_user_id=$request->v_user_id;
        $valuer_id=$request->valuer_id;
        
         
           $data=array();
           $data['v_user_id'] = $request->v_user_id;
           
           $data['valuer_id'] = $request->valuer_id;
           $encryptArray = $data;
           $request = array();
            $request['requestData'] = $encryptArray;
            
                
            
                $gatewayURL = config('setting.api_gateway_url').'/valuerlist/user_certify';
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                
                $response1 = json_decode($response);    
                if($response1->Status == 200 && $response1->Success){
                $objData = json_decode($this->decryptData($response1->Data));
                
        
                if ($objData->Code == 200) {
                    return redirect(route('approvedvaluers'))->with('success', 'Certificate Issued Successfully');
                }
        
                if ($objData->Code == 400) {
                    return redirect(route('Registration.index'))->with('fail', 'Registration Details Already Exists');
                    }
                }
        
        
                else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);exit;                            
                }
            
        }
    public function destroy($id)
    {
        //
    }
    public function Valuer_rating(Request $request){
        
        $method = 'Method => valuer_rating => index';
        $user_id=$request->session()->get("userID");
        $gatewayURL = config('setting.api_gateway_url').'/valuer/rating_index';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method); 
        $response = json_decode($response);
        $objData = json_decode($this->decryptData($response->Data));
        $code=$objData->Code;
        
        if($code=="401"){
    
            return redirect()->route('unauthenticated')->send();
       } 
        $rows = json_decode(json_encode($objData->Data), true); 
        $menus = $this->FillMenu();
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        
    
        return view('valuers.valuer_rating', compact('user_id','screen_permission','rows','menus','screens','modules'));
        
        
        
        
       

    }
    public function ratings_create(Request $request){
        try{
            
            $method = 'Method => UamModulesController => store';
          
            $countq = count($request->q);
                $data = array();   
                $user_id=$request->user_id;
                for($i=0; $i < $countq; $i++){
                $data['q'][$i] = $request['q'][$i+1]; 
                 $data['q'][$i]['table'] = 'user_rattings_qa_details';
                    $data['q'][$i]['user_id'] = $user_id;
                }
                $data['user_id']=$user_id;
                $encryptArray = $data;
                $request = array();
                $request['requestData'] = $encryptArray;            
            $gatewayURL = config('setting.api_gateway_url').'/valuer/ratings_create';
            $response = $this->serviceRequest($gatewayURL, 'POST',  json_encode($request), $method);
            $response = json_decode($response);
            $objData = json_decode($this->decryptData($response->Data));
            $code=$objData->Code;
            if($code=="401"){
        
                return redirect()->route('unauthenticated')->send();
           } 
            $rows = json_decode(json_encode($objData->Data), true); 
            $menus = $this->FillMenu();
            $permission = $this->FillScreensByUser();
            $screen_permission = $permission[0];
            if($menus=="401"){
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            $permission=$screen_permission['permissions'];
            return redirect(url('/Valuer_rating'))->with('success', 'Rattings Saved Successfully');
        }

        catch(\Exception $exc){ 
            echo $exc;           
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
         }


}
    public function allocate_stake_holder(Request $request)
    { 
        try{
        $mlhud_id_new=$request->session()->get("userID");     
        
        if($mlhud_id_new==null){
            return view('auth.login');
        }
        $method = 'Method => UamModulesController => store';
       
         $stake_status=$request->stake_status;
         
       
       
        if($stake_status ==""){
            
          $data = array();   
            $data['stake_holder_email'] = $request->stake_holder_email;
            $data['message'] = $request->message;
            $data['user_id'] = $request->user_id;   
            $data['stake_status']=$request->stake_status;
            $data['stake_holder_id']=$request->stake_holder_name;
            $data['valuer_user_id']=$request->mlhud_id;
            $data['mlhud_id_new']=$mlhud_id_new;
            $data['valuer_id']=$request->valuer_id;
            $encryptArray = $data;
            $request = array();
                $request['requestData'] = $encryptArray;
                $gatewayURL = config('setting.api_gateway_url').'/stakeholder/allocation';
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                $response1 = json_decode($response);

                if($response1->Status == 200 && $response1->Success){
                $objData = json_decode($this->decryptData($response1->Data));
                
                        if ($objData->Code == 200) {
                            return redirect(route('valuerlist.index'))->with('success', 'Allocated successfully');
                        }
            
                    if ($objData->Code == 400) {
                        return redirect(route('Registration.index'))->with('fail', 'Email Name Already Exists');
                        }
                }
                else {
                    $objData = json_decode($this->decryptData($response1->Data));
                    echo json_encode($objData->Code);exit;                            
                    }
                

            
        }
        else{
            
            
            $data = array();    
            $data['valuer_id']=$request->valuer_id;
            $data['stake_status']=$request->stake_status;
            $data['message']=$request->message_stake;
            $data['stake_holder_id']=$mlhud_id_new;
           
           if($request->stake_status !="mlhud"){
            $doc=$request->stake_doc;
            if($doc==null){
                $data['stake_doc_name'] = " "; 
            $data['stake_doc_path'] = " ";
            }
                else{
            $storagepath = public_path() . '/userdocuments/approval/stakeholders/'. $data['valuer_id'];
            
            $storagepath_f = '/userdocuments/approval/stakeholders/'. $data['valuer_id'];
            
            if (!File::exists($storagepath)) {
               
                File::makeDirectory($storagepath);
            }
            $data['stake_doc_path'] = $storagepath_f;
            
            
            $documentsf =  $request['stake_doc'];
           
            $files = $documentsf->getClientOriginalName();
            $findspace = array(' ', '&',"'",'"');
            $replacewith = array('-', '-');
            $proposal_files = str_replace($findspace, $replacewith, $files);
            $documentsf->move($storagepath, $proposal_files);
            $data['stake_doc_name'] = $proposal_files; 
        }
        }
        else{
            
            $data['stake_doc_name'] = " "; 
            $data['stake_doc_path'] = " ";
        }
            $encryptArray = $data;
            
           
            $request = array();
                $request['requestData'] = $encryptArray;
                $gatewayURL = config('setting.api_gateway_url').'/stakeholder/allocation';
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                $response1 = json_decode($response);
                if($response1->Status == 200 && $response1->Success){
                $objData = json_decode($this->decryptData($response1->Data));
                
                        if ($objData->Code == 200) {
                            return redirect(route('valuerlist.index'))->with('success', 'Reviewed successfully');
                        }
            
                    if ($objData->Code == 400) {
                        return redirect(route('Registration.index'))->with('fail', 'Email Name Already Exists');
                        }
                }
                else {
                    $objData = json_decode($this->decryptData($response1->Data));
                    echo json_encode($objData->Code);exit;                            
                    }
                }


        }
                
                             catch(\Exception $exc){ 
                echo $exc;           
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
             }
    

    }
}


