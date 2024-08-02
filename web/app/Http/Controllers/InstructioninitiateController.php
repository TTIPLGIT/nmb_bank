<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\Redirect;

class InstructioninitiateController extends BaseController
{
    // public function index(Request $request)
    // {  
    //     $user_id=$request->session()->get("userID");
    //     if($user_id==null){
    //         return view('auth.login');
    //     }
    //     $method = 'Method => vbpfeedbackController => index';
    //     $request =  array();
    //     $request['mlhud_id'] = $user_id;    
    //     $gatewayURL = config('setting.api_gateway_url').'/insrtuction/index';
        
    //     $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method); 
    //     $response = json_decode($response);
        
    //     $objData = json_decode($this->decryptData($response->Data));
       
    //     $code=$objData->Code;
        
    //     if($code=="401"){
    
    //         return redirect()->route('unauthenticated')->send();
    //    } 
    //     $rows = json_decode(json_encode($objData->Data), true); 
       
    //     $menus = $this->FillMenu();
    
    //     if($menus=="401"){
    //         return redirect(url('/'))->with('danger', 'User session Exipired');
    //     }
    //     $screens = $menus['screens'];
    //     $modules = $menus['modules'];

    //     return view('initiation.vpb_index', compact('user_id','rows','menus','screens','modules'));
    // }

    // public function create(Request $request)
    // {
    //     $user_id=$request->session()->get("userID");
    //     if($user_id==null){
    //         return view('auth.login');
    //     }
    //     $user_id=$request->session()->get("userID");
    //     $method = 'Method => vbpfeedbackController => create';
        
    //     $urd = "exp";
    //     if($urd == "exp"){
    //         $gatewayURL = config('setting.api_gateway_url').'/insrtuction/create';
    //     $response = $this->serviceRequest($gatewayURL, 'GET', '', $method); 
    //     $response = json_decode($response);
    //     $objData = json_decode($this->decryptData($response->Data)); 
    //     $rows = json_decode(json_encode($objData->Data), true); 
    //     $menus = $this->FillMenu();
    //     if($menus=="401"){
    //         return redirect(url('/'))->with('danger', 'User session Exipired');
    //     }
    //     $screens = $menus['screens'];
    //     $modules = $menus['modules'];
    //     return view('initiation.vpb_create', compact('rows','menus','screens','modules'));
    //     }
       
    // }
    public function store(Request $request)
    {
        
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $method = 'Method => vbpfeedbackController => master_store';
        
           $data=array();
           $data['stakeholder_id'] = $user_id;
           $data['instruction_name'] = $request->Instruction_name;
           $data['description'] = $request->description;
           
            $encryptArray = $data;
                $request = array();
                $request['requestData'] = $encryptArray;
            
                $gatewayURL = config('setting.api_gateway_url').'/stakeholder/storedata';
                
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                
                $response1 = json_decode($response);
                if($response1->Status == 200 && $response1->Success){
                $objData = json_decode($this->decryptData($response1->Data));
                
        
                if ($objData->Code == 200) {
                    return redirect(route('initiation/create'))->with('success', 'Initation Completed Successfully');
                }
        
                if ($objData->Code == 400) {
                    return redirect(route('initiation.vpb_create'))->with('fail', 'Initiation Details Already Exists');
                    }
                }
        
        
                else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);exit;                            
                }
            
     }

     public function show(Request $request)
    {    
        try {
            

            
        $method = 'Method => vbpfeedbackController => show';
        $data['id'] = $request->id;
       
        
         $encryptArray = $data;
             $request = array();
             $request['requestData'] = $encryptArray;

          // echo json_encode($id);exit;t
          $gatewayURL = config('setting.api_gateway_url').'/stakeholder/show';
          $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
          $response = json_decode($response);
          $this->WriteFileLog(json_encode($response));
          
          if($response->Status == 200 && $response->Success){
             $objData = json_decode($this->decryptData($response->Data));
             if ($objData->Code == 200) {
                $parant_data = json_decode(json_encode($objData->Data), true);
                $rows2 =  $parant_data['rows2'];
               
                return $rows2;
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
       
       public function index_data(Request $request)
    {  
        
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $method = 'Method => vbpfeedbackController => index';
        $request =  array();
        $request['mlhud_id'] = $user_id;    
        $gatewayURL = config('setting.api_gateway_url').'/insrtuction/index_data';
        
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

        return view('initiation.vpb_index', compact('user_id','rows','menus','screens','modules'));
    }
    
}


