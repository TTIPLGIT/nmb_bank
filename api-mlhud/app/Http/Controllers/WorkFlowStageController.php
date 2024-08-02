<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use DB;


class WorkFlowStageController extends BaseController
{

 public function get_data()
 {

    try {
        $method = 'Method => WorkFlowStageController => get_data';
        $rows = DB::table('work_flow_stage as a')
        ->select('a.stage_id','a.stage_name','a.description')
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
    $method = 'Method => WorkFlowStageController => storedata';
    $inputArray = $this->decryptData($request->requestData);
    $input = [
        'stage_name' => $inputArray['stage_name'],
        'description' => $inputArray['description'],
    ];
    DB::transaction(function() use($input) {
        $stage_id = DB::table('work_flow_stage')
        ->insertGetId([
            'stage_name' => $input['stage_name'],
            'description' => $input['description'],
            'created_by' => auth()->user()->id,
            'created_at' => NOW()
        ]);
        $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

    $role_name_fetch=$role_name[0]->role_name;
        $this->auditLog('work_flow_stage', $stage_id, 'Create', 'Create new work flow stage', auth()->user()->id, NOW(),$role_name_fetch);
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
    $method = 'Method => WorkFlowStageController => updatedata';
    $inputArray = $this->decryptData($request->requestData);
    $input = [
        'stage_name' => $inputArray['stage_name'],
        'description' => $inputArray['description'],
        'stage_id' => $inputArray['stage_id'], 
    ];

    DB::transaction(function() use($input) {
        DB::table('work_flow_stage')
        ->where('stage_id', $input['stage_id'])
        ->update([
            'stage_name' => $input['stage_name'],
            'description' => $input['description'],
            'last_modified_by' => auth()->user()->id,
            'last_modified_date' => NOW()
        ]);
        $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

    $role_name_fetch=$role_name[0]->role_name;
        $this->auditLog('work_flow_stage', $input['stage_id'] , 'Update', 'Update work flow stage', auth()->user()->id, NOW(),$role_name_fetch);
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
        $method = 'Method => WorkFlowStageController => data_edit';
        $id = $this->decryptData($id);

        $one_row  = DB::table('work_flow_stage')
        ->select('*')
        ->where('stage_id', $id)
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
        $method = 'Method => WorkFlowStageController => data_delete';
        $id = $this->decryptData($id);
        DB::transaction(function() use($id){
         $uam_modules_id =  DB::table('work_flow_stage')
         ->where('stage_id', $id)
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
