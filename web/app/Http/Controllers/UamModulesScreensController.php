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


class UamModulesScreensController extends BaseController
{

    public function index()
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if(strpos($screen_permission['permissions'], 'View') !== false){
            try{ 
                $method = 'Method => UamModulesScreensController => index'; 
                $gatewayURL = config('setting.api_gateway_url').'/uam_modules_screens/get_data';
                $response1 = $this->serviceRequest($gatewayURL, 'GET', '', $method); 
                $response = json_decode($response1);
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
                        return view('uam.uam_modules_screens.index', compact('rows','screens','modules','screen_permission'));
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
             $method = 'Method => UamModulesScreensController => create'; 
             $gatewayURL = config('setting.api_gateway_url').'/uam_modules_screens/getmodulesandscreens';
             $response = $this->serviceRequest($gatewayURL, 'GET', '', $method); 
             $response = json_decode($response);
             if($response->Status == 200 && $response->Success){
                 $objData = json_decode($this->decryptData($response->Data));
                 if ($objData->Code == 200) {
                     $parant_data = json_decode(json_encode($objData->Data), true);
                     $modulesdata =  $parant_data['modulesdata'];
                     $screensdata =  $parant_data['screensdata'];
                     $menus = $this->FillMenu();
                     $screens = $menus['screens'];
                     $modules = $menus['modules'];
                     return view('uam.uam_modules_screens.create',compact('modulesdata','screensdata','screens','modules'));
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
           $method = 'Method => UamModulesScreensController => screen_data_get';
           $data = array();
           $data['module_id'] = $request->module_id;
           $encryptArray = $this->encryptData($data);
           $request = array();
           $request['requestData'] = $encryptArray;
           $gatewayURL = config('setting.api_gateway_url').'/uam_modules_screens/screen_data_get';
           $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
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
       } catch(\Exception $exc){            
           echo $exc;          
           return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
       }
   }


    public function store(Request $request)
    {

        try {
           $method = 'Method => UamModulesScreensController => store';
           $data = array();
           $data['screen_id'] = $request->screen_id;
           $data['module_id'] = $request->module_id;
           $encryptArray = $this->encryptData($data);
           $request = array();
           $request['requestData'] = $encryptArray;
           $gatewayURL = config('setting.api_gateway_url').'/uam_modules_screens/storedata';
           $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
           $response = json_decode($response);
           if($response->Status == 200 && $response->Success){
               $objData = json_decode($this->decryptData($response->Data));
               if ($objData->Code == 200) {
                   return redirect(route('uam_modules_screens.index'))->with('success', 'Uam Modules Screens Created Successfully');
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
    public function show($id)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if(strpos($screen_permission['permissions'], 'Show') !== false){
 
            try {
             $method = 'Method => UamModulesScreensController => show';
             $id = $this->decryptData($id);
             $gatewayURL = config('setting.api_gateway_url').'/uam_modules_screens/data_edit/'.$this->encryptData($id);
            
             $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
             $response = json_decode($response);
             if($response->Status == 200 && $response->Success){
                 $objData = json_decode($this->decryptData($response->Data));
                 if ($objData->Code == 200) {
                     $parant_data = json_decode(json_encode($objData->Data), true);
                     $rows =  $parant_data['rows'];
                    
                     
                     
                     $screensdata =  $parant_data['screensdata'];
                     
                     
                     
                     $menus = $this->FillMenu();
                     $screens = $menus['screens'];
                     $modules = $menus['modules'];
                    
                     return view('uam.uam_modules_screens.show', compact('rows','screensdata','screens','modules'));
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
 


    public function get_modules_screen(Request $request)
    {
        try{ 
         $id = $request->module_id;
         $method = 'Method => UamModulesScreensController => get_modules_screen'; 
         $gatewayURL = config('setting.api_gateway_url').'/uam_modules_screens/get_modules_screen/'.$this->encryptData($id);
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
            Log::error('[Method => UamModulesScreensController =>  Error Code:' . $exc . '::' . auth()->user()->id . ']');
        }
    }


    public function update(Request $request, $id)
    {
        try {

            $method = 'Method => UamModulesScreensController => update';

            $screen_name  =  $request->screen_name;
            $id = $request->screen_id;


            $screen_check = DB::select("select * from uam_screens where screen_name = '$screen_name' and id != '$id' and active_flag = 0 ");




            if ($screen_check == []) {

                DB::transaction(function () use ($request) {

                    $screenidcount = count($request->screen_id);

                    for ($i = 0; $i < $screenidcount; $i++) {
    
                        $screen_permission_id = DB::table('uam_module_screens')->insertGetId([
                            'screen_id' =>  $request->screen_id[$i],
                            'module_id' => $request->module_id,
                            'active_flag' => 0,
                            'created_by' => auth()->user()->id,
                            'created_date' => NOW()
                        ]);
                    }
                });

                return redirect()->route('uam_screens.index')->with('success', 'Updated Sucessfully');
            } else {
                return redirect()->route('uam_screens.index')->with('error', 'Already Exist');
            }
        } catch (Exception $exc) {
            Log::error('[Method => UamModulesScreensController =>  Error Code:' . $exc . '::' . auth()->user()->id . ']');
        }
    }


    public function destroy($id)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if(strpos($screen_permission['permissions'], 'Delete') !== false){
            
          try {
            $method = 'Method => UamModulesScreensController => delete';
            $id = $this->decryptData($id);
            $gatewayURL = config('setting.api_gateway_url').'/uam_modules_screens/data_delete/'.$this->encryptData($id);
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response1 = json_decode($response);
            if($response1->Status == 200 && $response1->Success){
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                 return redirect(route('uam_modules_screens.index'))->with('success', 'UAM Module Screen Deleted Successfully');
             }
             if ($objData->Code == 400) {
                 return redirect(route('uam_modules_screens.index'))->with('fail', 'This Module Screen Allocated One Role');
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
