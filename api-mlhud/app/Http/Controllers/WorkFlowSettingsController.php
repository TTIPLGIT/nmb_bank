<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use DB;


class WorkFlowSettingsController extends BaseController
{
   
   public function get_data()
    {
        //echo "naa";exit;
        try {
            $method = 'Method => WorkFlowSettingsController => get_data';
            $rows = DB::table('work_flow_settings as a')
                ->select('a.settings_id','a.settings_name','a.description')
                ->get();
             $response = [
            'rows' => $rows
        ];

        $serviceResponse = array();
        $serviceResponse['Code'] = config('setting.status_code.success');
        $serviceResponse['Message'] = config('setting.status_message.success');
        $serviceResponse['Data'] = $response;
        $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
        $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
        return $sendServiceResponse;

        } catch(\Exception $exc){
      $exceptionResponse = array();
      $exceptionResponse['ServiceMethod'] = $method;
      $exceptionResponse['Exception'] = $exc->getMessage();
      $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
      $serviceResponse = array();
      $serviceResponse['Code'] = config('setting.status_code.exception');
      $serviceResponse['Message'] = $exc->getMessage();
      $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
      $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
      return $sendServiceResponse;
        }
    }

  


    public function storedata(Request $request)
    {
          try {
            $method = 'Method => WorkFlowSettingsController => storedata';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'settings_name' => $inputArray['settings_name'],
                'description' => $inputArray['description'],
                'default_status' => $inputArray['default_status'],
            ];
                DB::transaction(function() use($input) {
                    $settings_id = DB::table('work_flow_settings')
                        ->insertGetId([
                            'settings_name' => $input['settings_name'],
                            'description' => $input['description'],
                            'default_status' => $input['default_status'],
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                        $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

                  $role_name_fetch=$role_name[0]->role_name;
                    $this->auditLog('work_flow_settings', $settings_id, 'Create', 'Create new work flow settings', auth()->user()->id, NOW(),$role_name_fetch);
                });
               

        $serviceResponse = array();
        $serviceResponse['Code'] = config('setting.status_code.success');
        $serviceResponse['Message'] = config('setting.status_message.success');
        $serviceResponse['Data'] = 1;
        $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
        $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
        return $sendServiceResponse;

        } catch(\Exception $exc){
             $exceptionResponse = array();
      $exceptionResponse['ServiceMethod'] = $method;
      $exceptionResponse['Exception'] = $exc->getMessage();
      $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
      $serviceResponse = array();
      $serviceResponse['Code'] = config('setting.status_code.exception');
      $serviceResponse['Message'] = $exc->getMessage();
      $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
      $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
      return $sendServiceResponse;
        }
    }



  public function updatedata(Request $request)
    {
          try {
            $method = 'Method => WorkFlowSettingsController => updatedata';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'settings_name' => $inputArray['settings_name'],
                'description' => $inputArray['description'],
                'settings_id' => $inputArray['settings_id'], 
                'default_status' => $inputArray['default_status'],
            ];

                DB::transaction(function() use($input) {
                    DB::table('work_flow_settings')
                    ->where('settings_id', $input['settings_id'])
                        ->update([
                            'settings_name' => $input['settings_name'],
                            'description' => $input['description'],
                            'default_status' => $input['default_status'],
                            'last_modified_by' => auth()->user()->id,
                            'last_modified_date' => NOW()
                        ]);
                        $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

                           $role_name_fetch=$role_name[0]->role_name;
                    $this->auditLog('work_flow_settings', $input['settings_id'] , 'Update', 'Update work flow settings', auth()->user()->id, NOW(),$role_name_fetch);
                });
               

        $serviceResponse = array();
        $serviceResponse['Code'] = config('setting.status_code.success');
        $serviceResponse['Message'] = config('setting.status_message.success');
        $serviceResponse['Data'] = 1;
        $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
        $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
        return $sendServiceResponse;

            
        } catch(\Exception $exc){
             $exceptionResponse = array();
      $exceptionResponse['ServiceMethod'] = $method;
      $exceptionResponse['Exception'] = $exc->getMessage();
      $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
      $serviceResponse = array();
      $serviceResponse['Code'] = config('setting.status_code.exception');
      $serviceResponse['Message'] = $exc->getMessage();
      $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
      $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
      return $sendServiceResponse;
        }
    }



  public function data_edit($id)
    {
        try{
            $method = 'Method => WorkFlowSettingsController => data_edit';
            $id = $this->decryptData($id);
          $one_row = DB::table('work_flow_settings')
                ->select('*')
                ->where('settings_id', $id)
                ->get();

                 $response = [
            'one_row' => $one_row 
        ];

        $serviceResponse = array();
        $serviceResponse['Code'] = config('setting.status_code.success');
        $serviceResponse['Message'] = config('setting.status_message.success');
        $serviceResponse['Data'] = $response;
        $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
        $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
        return $sendServiceResponse;



            return $this->sendDataResponse($rows);             
        }catch(\Exception $exc){
             $exceptionResponse = array();
      $exceptionResponse['ServiceMethod'] = $method;
      $exceptionResponse['Exception'] = $exc->getMessage();
      $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
      $serviceResponse = array();
      $serviceResponse['Code'] = config('setting.status_code.exception');
      $serviceResponse['Message'] = $exc->getMessage();
      $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
      $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
      return $sendServiceResponse;
        }
    }




    public function data_delete($id)
    {
        try{
            $method = 'Method => WorkFlowSettingsController => data_delete';
            $id = $this->decryptData($id);
                DB::transaction(function() use($id){
                   $uam_modules_id =  DB::table('work_flow_settings')
                    ->where('settings_id', $id)
                    ->delete();                  
                });
                $serviceResponse = array();
        $serviceResponse['Code'] = config('setting.status_code.success');
        $serviceResponse['Message'] = config('setting.status_message.success');
        $serviceResponse['Data'] = 1;
        $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
        $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
        return $sendServiceResponse;               
        }catch(\Exception $exc){
             $exceptionResponse = array();
      $exceptionResponse['ServiceMethod'] = $method;
      $exceptionResponse['Exception'] = $exc->getMessage();
      $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
      $serviceResponse = array();
      $serviceResponse['Code'] = config('setting.status_code.exception');
      $serviceResponse['Message'] = $exc->getMessage();
      $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
      $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
      return $sendServiceResponse;
        }
    }




  
}
