<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Model\nature_of_workmodel;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;


class UamModulesController extends BaseController
{

    public function index()
    {
      // $user= (auth()->check()) ? auth()->user()->id : null;
      // $user= Auth::user()->name;
      // $user=auth()->user()->id;
      // dd($user);
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
       
     
       
        if(strpos($screen_permission['permissions'], 'View') !== false){
          try{ 
             $method = 'Method => UamModulesController => index'; 
             $gatewayURL = config('setting.api_gateway_url').'/uam_modules/get_data';
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
                   return view('uam.uam_modules.index', compact('rows','screens','modules','screen_permission'));
                }
                if($objData->Code=="401"){
            
                    return redirect()->route('unauthenticated')->send();
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
          $method = 'Method => UamModulesController => create';
          $gatewayURL = config('setting.api_gateway_url').'/uam_modules/get_uam_modules';
          $response = $this->serviceRequest($gatewayURL, 'GET', '', $method); 
          $response = json_decode($response);
          if($response->Status == 200 && $response->Success)
          {
             $objData = json_decode($this->decryptData($response->Data));
        
             if ($objData->Code == 200) {
                $parant_data = json_decode(json_encode($objData->Data), true);
                $rows =  $parant_data['rows'];
                
                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                return view('uam.uam_modules.create', compact('rows','screens','modules'));
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
       else{
        return redirect()->route('not_allow');
     }
    
    
    }
    

    public function store(Request $request)
    
    {
        try {
            
           $method = 'Method => UamModulesController => store';
           $data = array();
           $data['module_name'] = $request->module_name;
           $data['display_order'] = $request->display_order;
           $data['parent_module_id'] = $request->parent_module_id;
           $data['module_type'] = $request->module_type;
           $data['class_name'] = $request->class_name;
           $encryptArray = $this->encryptData($data);
           $request = array();
           $request['requestData'] = $encryptArray;

           $gatewayURL = config('setting.api_gateway_url').'/uam_modules/storedata';
           
           $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
           $response1 = json_decode($response);
           if($response1->Status == 200 && $response1->Success){
              $objData = json_decode($this->decryptData($response1->Data));
     
              if ($objData->Code == 200) {
                 return redirect(route('uam_modules.index'))->with('success', 'Uam Module Created Successfully');
              }
     
              if ($objData->Code == 400) {
                return redirect(route('uam_modules.index'))->with('fail', 'Uam Module Name Already Exists');
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
          $method = 'Method => UamModulesController => show';
          $id = $this->decryptData($id);
          // echo json_encode($id);exit;
          $gatewayURL = config('setting.api_gateway_url').'/uam_modules/data_edit/'.$this->encryptData($id);
          $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
          $response = json_decode($response);
          if($response->Status == 200 && $response->Success){
             $objData = json_decode($this->decryptData($response->Data));
             if ($objData->Code == 200) {
                $parant_data = json_decode(json_encode($objData->Data), true);
                $rows =  $parant_data['rows'];
                $one_row =  $parant_data['one_rows'];
                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                return view('uam.uam_modules.show', compact('rows','one_row','screens','modules'));
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
          $method = 'Method => UamModulesController => edit';
          $id = $this->decryptData($id);
          
          $gatewayURL = config('setting.api_gateway_url').'/uam_modules/data_edit/'.$this->encryptData($id);
          $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

          $response = json_decode($response);
         
          if($response->Status == 200 && $response->Success){
             $objData = json_decode($this->decryptData($response->Data));
             if ($objData->Code == 200) {
                $parant_data = json_decode(json_encode($objData->Data), true);
                $rows =  $parant_data['rows'];
                $one_row =  $parant_data['one_rows'];
                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                return view('uam.uam_modules.edit', compact('rows','one_row','screens','modules'));
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
       else{
        return redirect()->route('not_allow');
     }
    
    
    }
    


    public function update(Request $request, $id)
    {
        try {
           $method = 'Method => UamModulesController => update_data';
           $data = array();
           $data['module_name'] = $request->module_name;
           $data['display_order'] = $request->display_order;
           $data['parent_module_id'] = $request->parent_module_id;
           $data['module_id'] = $request->module_id;
           $data['module_type'] = $request->module_type;
           $data['class_name'] = $request->class_name;
           $encryptArray = $this->encryptData($data);
           $request = array();
           $request['requestData'] = $encryptArray;
           $gatewayURL = config('setting.api_gateway_url').'/uam_modules/updatedata';
           $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
           $response1 = json_decode($response);
           if($response1->Status == 200 && $response1->Success){
              $objData = json_decode($this->decryptData($response1->Data));
              if ($objData->Code == 200) {
                 return redirect(route('uam_modules.index'))->with('success', 'Uam Modules Updated Successfully');
              }
              if ($objData->Code == 400) {
                return Redirect::back()->with('fail', 'Uam Module Name Already Exists');
               }
               
           }
           else {
              $objData = json_decode($this->decryptData($response1->Data));
              echo json_encode($objData->Code);exit;                            
           }
        } catch(\Exception $exc){            
           return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
     }
     
    public function destroy($id)
    {


        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if(strpos($screen_permission['permissions'], 'Delete') !== false){
    
       try {
          $method = 'Method => UamModulesController => delete';
          $id = $this->decryptData($id);
          $gatewayURL = config('setting.api_gateway_url').'/uam_modules/data_delete/'.$this->encryptData($id);
          $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
          $response1 = json_decode($response);
          if($response1->Status == 200 && $response1->Success){
             $objData = json_decode($this->decryptData($response1->Data));
             if ($objData->Code == 200) {
                return redirect(route('uam_modules.index'))->with('success', 'Uam Modules Deleted Successfully.');
             }
             if ($objData->Code == 400) {
                return redirect(route('uam_modules.index'))->with('fail', 'This Module Allocated One Module Screen Mapping');
             }
          }
          else {
             $objData = json_decode($this->decryptData($response1->Data));
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
    

   }