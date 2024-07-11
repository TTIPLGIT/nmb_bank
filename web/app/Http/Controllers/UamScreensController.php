<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Model\nature_of_workmodel;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;


class UamScreensController extends BaseController
{

    public function index()
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        
        if(strpos($screen_permission['permissions'], 'View') !== false){
           try{ 
               $method = 'Method => UamScreensController => index'; 
               $gatewayURL = config('setting.api_gateway_url').'/uam_screens/get_data';
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
                       $permission = $this->FillScreensByUser();
                       $screen_permission = $permission[0];
                       return view('uam.uam_screens.index', compact('rows','screens','modules','screen_permission'));
                   }
               } 
               else {
                   $objData = json_decode($this->decryptData($response->Data));
                   echo json_encode($objData->Code);exit;                            
               }
           }
           catch(\Exception $exc){  
               echo $exc;          
               return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
           }
       }
       
       else{
           return redirect()->route('not_allow');
       }
       
       }
       
    public function create()
    {
    $permission_data = $this->FillScreensByUser();
    $screen_permission = $permission_data[0];
    if(strpos($screen_permission['permissions'], 'Create') !== false){
        try{ 
            $method = 'Method => UamScreensController => create'; 
            $gatewayURL = config('setting.api_gateway_url').'/uam_screens/get_work_flow_data';
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
                $permissions = config('permission.screen_permission');
                return view('uam.uam_screens.create', compact('rows','permissions','screens','modules'));
            }  
        }
        else {
            $objData = json_decode($this->decryptData($response->Data));
            echo json_encode($objData->Code);exit;                            
        }
    }
    catch(\Exception $exc){
       echo $exc;          
       return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
   }
}
else{
    return redirect()->route('not_allow');
}

}



    public function store(Request $request)
    {
        try {
            $method = 'Method => UamScreensController => store';
            
            $data = array();
            $data['screen_name'] = $request->screen_name;
            $data['screen_url'] = $request->screen_url;
            $data['route_url'] = $request->route_url;
           
            $data['display_order'] = $request->display_order;
            $data['screen_permission'] = $request->screen_permission;
            $data['work_flow_id'] = $request->work_flow_id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url').'/uam_screens/storedata';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if($response1->Status == 200 && $response1->Success){
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                 return redirect(route('uam_screens.index'))->with('success', 'Uam Screen Created Successfully');
             }
    
              if ($objData->Code == 400) {
               return Redirect::back()->with('fail', 'Uam Screen Name Already Exists');
              }
    
         }
         else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);exit;                            
        }
    
    
    } catch(\Exception $exc){            
     echo $exc;          
     return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
    }
     
    public function show($id)
    {
        $permission_data = $this->FillScreensByUser();
    $screen_permission = $permission_data[0];
    if(strpos($screen_permission['permissions'], 'Show') !== false){
    try {
        $method = 'Method => UamScreensController => show';
        $id = $this->decryptData($id);
        $gatewayURL = config('setting.api_gateway_url').'/uam_screens/data_edit/'.$this->encryptData($id);
        $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
        $response = json_decode($response);
        if($response->Status == 200 && $response->Success){
          $objData = json_decode($this->decryptData($response->Data));
          if ($objData->Code == 200) {
            $parant_data = json_decode(json_encode($objData->Data), true);
            $rows =  $parant_data['rows'];
            // $work_flow_row =  $parant_data['work_flow_row'];
            $menus = $this->FillMenu();  
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            $permissions = config('permission.screen_permission');
            return view('uam.uam_screens.show', compact('rows','permissions','screens','modules'));
        }  
    }
    else {
        $objData = json_decode($this->decryptData($response->Data));
        echo json_encode($objData->Code);exit;                            
    }

} catch(\Exception $exc){    
    echo $exc;          
    return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
}
}

 else{
    return redirect()->route('not_allow');
}


}



    public function edit($id)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if(strpos($screen_permission['permissions'], 'Edit') !== false){
        try {
            $method = 'Method => UamScreensController => edit';
            $id = $this->decryptData($id);
            $gatewayURL = config('setting.api_gateway_url').'/uam_screens/data_edit/'.$this->encryptData($id);
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if($response->Status == 200 && $response->Success){
              $objData = json_decode($this->decryptData($response->Data));
              if ($objData->Code == 200) {
                $parant_data = json_decode(json_encode($objData->Data), true);
                $rows =  $parant_data['rows'];
                // $work_flow_row =  $parant_data['work_flow_row'];
                $menus = $this->FillMenu();  
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                $permissions = config('permission.screen_permission');
                return view('uam.uam_screens.edit', compact('rows','permissions','screens','modules'));
            }  
        }
        else {
            $objData = json_decode($this->decryptData($response->Data));
            echo json_encode($objData->Code);exit;                            
        }
    
    } catch(\Exception $exc){    
        echo $exc;          
        return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
    
    }
     else{
        return redirect()->route('not_allow');
    }
    
    }

    public function getscreenpermission(Request $request)
    {
        try{ 
            $id = $request->screen_id;
            $method = 'Method => UamScreensController => getscreenpermission'; 
            $gatewayURL = config('setting.api_gateway_url').'/uam_screens/getscreenpermission/'.$this->encryptData($id);
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method); 
            $response = json_decode($response);
            if($response->Status == 200 && $response->Success){
              $objData = json_decode($this->decryptData($response->Data));
              if ($objData->Code == 200) {
                $parant_data = json_decode(json_encode($objData->Data), true);
                $rows =  $parant_data['rows'];
                return $rows;
            }  
        }
        else {
            $objData = json_decode($this->decryptData($response->Data));
            echo json_encode($objData->Code);exit;                            
        }
    }catch(\Exception $exc){
     echo $exc;          
     return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
    }
    


    public function update(Request $request, $id)
    {

        try {
            $method = 'Method => UamScreensController => update_data';
            $data = array();
            $data['screen_name'] = $request->screen_name;
            $data['screen_url'] = $request->screen_url;
            $data['route_url'] = $request->route_url;
            $data['class_name'] = $request->class_name;
            $data['display_order'] = $request->display_order;
            $data['screen_id'] = $request->screen_id;
            $data['work_flow_id'] = $request->work_flow_id;
            $data['screen_permission'] = $request->screen_permission;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url').'/uam_screens/updatedata';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
    
    
            if($response1->Status == 200 && $response1->Success){
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                 return redirect(route('uam_screens.index'))->with('success', 'Uam Screen Updated Successfully');
             }
    
              if ($objData->Code == 400) {
               return Redirect::back()->with('fail', 'Uam Screen Name Already Exists');
              }
    
    
         }
         else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);exit;                            
        }
    
    } catch(\Exception $exc){            
     echo $exc;          
     return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
    }
    

    public function destroy($id)
    {
        $permission_data = $this->FillScreensByUser();
    $screen_permission = $permission_data[0];
    if(strpos($screen_permission['permissions'], 'Delete') !== false){
    try {
        $method = 'Method => UamScreensController => delete';
        $id = $this->decryptData($id);
        $gatewayURL = config('setting.api_gateway_url').'/uam_screens/data_delete/'.$this->encryptData($id);
        $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
        $response1 = json_decode($response);
        if($response1->Status == 200 && $response1->Success){
            $objData = json_decode($this->decryptData($response1->Data));
            if ($objData->Code == 200) {
             return redirect(route('uam_screens.index'))->with('success', 'UAM Screen Deleted Successfully');
         }
         if ($objData->Code == 400) {
             return redirect(route('uam_screens.index'))->with('fail', 'This Screen Allocated One Module Screen Mapping');
         }
     }
 } catch(\Exception $exc){            
     echo $exc;          
     return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
 }

 } 
 else{
    return redirect()->route('not_allow');
}


}

}
