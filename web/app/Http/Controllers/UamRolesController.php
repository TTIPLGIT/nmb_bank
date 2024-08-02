<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Model\nature_of_workmodel;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;


class UamRolesController extends BaseController
{

    public function index()
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if(strpos($screen_permission['permissions'], 'View') !== false){
            try{ 
                $method = 'Method => UamRolesController => index'; 
                $gatewayURL = config('setting.api_gateway_url').'/uam_roles/get_data';
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
                        return view('uam.uam_roles.index', compact('rows','screens','modules','screen_permission'));
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
            $method = 'Method => UamRolesController => create';


            $gatewayURL = config('setting.api_gateway_url').'/uam_roles/getmodulesandscreens';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if($response->Status == 200 && $response->Success){
                $objData = json_decode($this->decryptData($response->Data));
               
               
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $module_data =  $parant_data['module_data'];

                    $screens_data =  $parant_data['screens_data'];
                    $permissions_data =  $parant_data['permissions_data'];
                    $parent_module_data =  $parant_data['parent_module_data'];
                    
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    

                    return view('uam.uam_roles.create',compact('module_data','screens_data','permissions_data','parent_module_data','screens','modules'));
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

    public function screen_data_get(Request $request)
    {
        try {
            $id = $request->module_id;

            $rows =  DB::select("select a.id as screen_id, a.screen_name,string_agg(b.permission, ',')  AS permissions from uam_screens as a 
            inner join uam_screen_permissions as b on b.screen_id = a.id
            where a.active_flag = 0 and  a.id not in (select c.id from uam_module_screens as c where (c.module_id = $id and c.active_flag = 0))  group by a.id");


            return $rows;
        } catch (Exception $exc) {
            Log::error('[Method => UamScreensController =>  Error Code:' . $exc . '::' . auth()->user()->id . ']');
        }
    }


    public function store(Request $request)
    {
           
        //return $request;
    
       try {
        $method = 'Method => UamRolesController => storedata';
        $rules = [
            'role_name' => 'required',
            'screen_id' => 'required',
        ];
    
        $messages = [
            'role_name.required' => 'Role name is required',
            'screen_id.required' => 'Screen is required',
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if($validator->fails()){
         return Redirect::back()->withErrors($validator);
     }else{
    
      $directorate = $request->screen_id;
      $screen_id =  explode("-", $directorate); 
      $directorate1 = $request->permission_id;
      $permission_id =  explode(":", $directorate1);
    
    
    
          //$permissiondata = substr($screen_id[0],2);
    
          // echo json_encode($screen_id);
          // exit;
    
         // echo json_encode(trim($screen_id, $screen_id[0]));exit;
    
    
    
      $data = array();
      $data['role_name'] = $request->role_name;
      $data['screen_id'] = $screen_id;
      $data['permission_id'] = $permission_id;
      $encryptArray = $this->encryptData($data);
      $request = array();
      $request['requestData'] = $encryptArray;
      $gatewayURL = config('setting.api_gateway_url').'/uam_roles/storedata';
      $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
      $response = json_decode($response);
      if($response->Status == 200 && $response->Success){
        $objData = json_decode($this->decryptData($response->Data));
        if ($objData->Code == 200) {
           return redirect(route('uam_roles.index'))->with('success', 'UAM Role Created Successfully');
       }
       if ($objData->Code == 400) {
           return redirect(route('uam_roles.index'))->with('fail', 'UAM Role Name Already Exists');
       }
    }
    else {
        $objData = json_decode($this->decryptData($response->Data));
        echo json_encode($objData->Code);exit;                            
    }
    
    }
    
    } catch(\Exception $exc){            
     echo $exc;          
     return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
    }
    
    public function edit($id)
    {

      

        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if(strpos($screen_permission['permissions'], 'Edit') !== false){
     
         try {
             $method = 'Method => UamRolesController => edit';
             $id = $this->decryptData($id);
             $gatewayURL = config('setting.api_gateway_url').'/uam_roles/data_edit/'.$this->encryptData($id);
             $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
             $response = json_decode($response);
             if($response->Status == 200 && $response->Success){
                 $objData = json_decode($this->decryptData($response->Data));
                 if ($objData->Code == 200) {
                     $parant_data = json_decode(json_encode($objData->Data), true);
                     $module_data =  $parant_data['module_data'];
                     $screens_data =  $parant_data['screens_data'];
                     $permissions_data =  $parant_data['permissions_data'];
                     $parent_module_data =  $parant_data['parent_module_data'];
                     $rows =  $parant_data['rows'];
                     $menus = $this->FillMenu();
                     $screens = $menus['screens'];
                     $modules = $menus['modules'];
                     return view('uam.uam_roles.edit',compact('module_data','screens_data','permissions_data','parent_module_data','rows','screens','modules'));
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
     
    public function show($id)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if(strpos($screen_permission['permissions'], 'Show') !== false){
            try {
              $method = 'Method => UamRolesController => show';
              $id = $this->decryptData($id);
              $gatewayURL = config('setting.api_gateway_url').'/uam_roles/data_edit/'.$this->encryptData($id);
              $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
              $response = json_decode($response);
              if($response->Status == 200 && $response->Success){
                  $objData = json_decode($this->decryptData($response->Data));
                  if ($objData->Code == 200) {
                      $parant_data = json_decode(json_encode($objData->Data), true);
                      $module_data =  $parant_data['module_data'];
                      $screens_data =  $parant_data['screens_data'];
                      $permissions_data =  $parant_data['permissions_data'];
                      $parent_module_data =  $parant_data['parent_module_data'];
                      
                      $rows =  $parant_data['rows'];
                      $menus = $this->FillMenu();
                      $screens = $menus['screens'];
                      $modules = $menus['modules'];
                      return view('uam.uam_roles.show',compact('rows','module_data','parent_module_data','screens_data','permissions_data','screens','modules'));
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
        try {
            $id = $request->screen_id;



            $one_row = DB::table('uam_screen_permissions as a')

                ->select('a.id', 'a.permission')

                ->where('a.screen_id', $id)
                ->get();


            return $one_row;
        } catch (Exception $exc) {
            Log::error('[Method => UamRolesController =>  Error Code:' . $exc . '::' . auth()->user()->id . ']');
        }
    }


    public function update(Request $request)
    {
        
        

        $method = 'Method => UamRolesController => update_data';
     
        try {
            $rules = [
             'role_name' => 'required',
             'screen_id' => 'required',
         ];
     
         $messages = [
             'role_name.required' => 'Role name is required',
             'screen_id.required' => 'Screen is required',
         ];
     
         $validator = Validator::make($request->all(), $rules, $messages);
     
         if($validator->fails()){
          return Redirect::back()->withErrors($validator);
      }else{
     
          $directorate = $request->screen_id;
          $screen_id =  explode("-", $directorate); 
          $directorate1 = $request->permission_id;
          $permission_id =  explode(":", $directorate1);
     
          $data = array();
          $data['role_name'] = $request->role_name;
          $data['role_id'] = $request->role_id;
          $data['screen_id'] = $screen_id;
          $data['permission_id'] = $permission_id;
          $encryptArray = $this->encryptData($data);
          $request = array();
          $request['requestData'] = $encryptArray;
          $gatewayURL = config('setting.api_gateway_url').'/uam_roles/updatedata';
          $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
          $response = json_decode($response);
          if($response->Status == 200 && $response->Success)
          {
             $objData = json_decode($this->decryptData($response->Data));
             if ($objData->Code == 200) {
                return redirect(route('uam_roles.index'))->with('success', 'UAM Role Updated Successfully');
            }
            if ($objData->Code == 400) {
                return redirect(route('uam_roles.index'))->with('fail', 'UAM Role Name Already Exists');
            }
     
        }
        else {
         $objData = json_decode($this->decryptData($response->Data));
         echo json_encode($objData->Code);exit;                            
     }
     
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
            $method = 'Method => UamRolesController => delete';
            $id = $this->decryptData($id);
            $gatewayURL = config('setting.api_gateway_url').'/uam_roles/data_delete/'.$this->encryptData($id);
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response1 = json_decode($response);
            if($response1->Status == 200 && $response1->Success){
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                   return redirect(route('uam_roles.index'))->with('success', 'UAM Role Deleted Successfully');
               }
               if ($objData->Code == 400) {
                   return redirect(route('uam_roles.index'))->with('fail', 'This Role Allocated One User');
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
