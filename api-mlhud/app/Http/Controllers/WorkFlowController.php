<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use DB;


class WorkFlowController extends BaseController
{

 public function get_stage_user_settings()
 {

    try {
        $method = 'Method => WorkFlowController => get_stage_data';

        $rows = DB::table('work_flow_stage as a')
        ->select('a.stage_id','a.stage_name','a.description')
        ->get();

        $settings = DB::table('work_flow_settings as a')
        ->select('a.settings_id','a.settings_name','a.description')
        ->get();

        $users = DB::table('users as a')
        ->select('a.id','a.name','a.email')
        ->get();


        $response = [
            'rows' => $rows,
            'settings' => $settings,
            'users' => $users
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



public function work_flow_data()
{

    try {
        $method = 'Method => WorkFlowController => work_flow_data';
        $rows = DB::table('work_flow as a')
        ->select('a.work_flow_id','a.work_flow_name','a.work_flow_description','a.work_flow_attachment','a.status')
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
    $method = 'Method => WorkFlowController => storedata';
    $inputArray = $this->decryptData($request->requestData);

    $input = [
        'workflow_name' => $inputArray['workflow_name'],
        'description' => $inputArray['description'],
        'attachment' => $inputArray['attachment'],
    ];

    $work_flow_id = DB::table('work_flow')
    ->insertGetId([
        'work_flow_name' => $input['workflow_name'],
        'work_flow_description' => $input['description'],
        'work_flow_attachment' => $input['attachment'],
        'created_by' => auth()->user()->id,
        'created_at' => NOW()
    ]);
$role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

    $role_name_fetch=$role_name[0]->role_name;
    $this->auditLog('work_flow', $work_flow_id, 'Create', 'Create new work flow', auth()->user()->id, NOW(),$role_name_fetch);


    $serviceResponse = array();
    $serviceResponse['Code'] = config('setting.status_code.success');
    $serviceResponse['Message'] = config('setting.status_message.success');
    $serviceResponse['Data'] = $work_flow_id;
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


public function onestoredata(Request $request)
{
  try {
    $method = 'Method => WorkFlowController => onestoredata';
    $inputArray = $this->decryptData($request->requestData);

    $input = [
        'day_count' => $inputArray['day_count'],
        'work_flow_id' => $inputArray['work_flow_id'],
        'level_name' => $inputArray['level_name'],
        'stage_id' => $inputArray['stage_id'],
        'user_id' => $inputArray['user_id'],
        'level_id' => $inputArray['level_id'],
        'settings_id' => $inputArray['settings_id']
    ];
    $settings_id =  $input['settings_id'];

    $stringsettings_id=implode(",",$settings_id);

    $user_id =  $input['user_id'];

    $stringuser_id =implode(",",$user_id);


          //echo json_encode($string);exit;

       //echo preg_replace([],$user_id);

   // echo json_encode($input);exit;
    DB::transaction(function() use($input,$stringsettings_id,$stringuser_id) {

        $work_flow_level_id = DB::table('work_flow_level')->insertGetId([
            'work_flow_id' => $input['work_flow_id'],
            'work_flow_level_name' => $input['level_name'],
            'stage_id' => $input['stage_id'],
            'level_id' => $input['level_id'],
            'created_by' => auth()->user()->id,
            'created_at' => NOW()
        ]);
        $useridcount = count($input['user_id']);
        for ($i=0; $i < $useridcount; $i++) { 
           $work_flow_level_user_id = DB::table('work_flow_level_user')->insertGetId([
            'work_flow_level_id' => $work_flow_level_id,
            'user_id' => $input['user_id'][$i],
            'array_users' =>$stringuser_id,
            'created_by' => auth()->user()->id,
            'created_at' => NOW()
        ]);

        //     $user_notification = DB::table('notifications')->insertGetId([
        //     'notification_type' => 'work flow',
        //     'notification_type_id' =>$work_flow_level_id,
        //     'user_id' => $input['user_id'][$i],
        //      'notification_status' => 0,
        //     'created_by' => auth()->user()->id,
        //     'created_at' => NOW()
        // ]);

       }
       $settingsidcount = count($input['settings_id']);
       for ($i=0; $i < $settingsidcount; $i++) { 
           $work_flow_level_settings_id = DB::table('work_flow_level_settings')->insertGetId([
            'work_flow_level_id' => $work_flow_level_id,
            'settings_id' => $input['settings_id'][$i],
            'array_settings' => $stringsettings_id,
            'day_count' =>$input['day_count'],
            'created_by' => auth()->user()->id,
            'created_at' => NOW()
        ]);
       }
       $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

    $role_name_fetch=$role_name[0]->role_name;
       $this->auditLog('work_flow_level', $work_flow_level_id, 'Create', 'Create new work flow level', auth()->user()->id, NOW(),$role_name_fetch);
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


public function oneupdatedata(Request $request)
{
  try {
    $method = 'Method => WorkFlowController => oneupdatedata';
    $inputArray = $this->decryptData($request->requestData);

    $input = [
        'work_flow_id' => $inputArray['work_flow_id'],
        'work_flow_level_id' => $inputArray['work_flow_level_id'],
        'stage_id' => $inputArray['stage_id'],
        'user_id' => $inputArray['user_id'],
        'settings_id' => $inputArray['settings_id'],
        'day_count' => $inputArray['day_count'],
    ];
    $settings_id =  $input['settings_id'];

    $stringsettings_id=implode(",",$settings_id);

    $user_id =  $input['user_id'];

    $stringuser_id =implode(",",$user_id);


    $rows1 = DB::table('work_flow_level_user')->where('work_flow_level_id', $input['work_flow_level_id'])->delete();

    $rows2 = DB::table('work_flow_level_settings')->where('work_flow_level_id', $input['work_flow_level_id'])->delete();

// $rows22 = DB::table('notifications')->where('notification_type_id', $input['work_flow_level_id'])->delete();

    DB::transaction(function() use($input,$stringsettings_id,$stringuser_id) {

        DB::table('work_flow_level')
        ->where('work_flow_level_id', $input['work_flow_level_id'])
        ->update([
            'stage_id' => $input['stage_id'],
            'last_modified_by' => auth()->user()->id,
            'last_modified_date' => NOW()
        ]);



        $useridcount = count($input['user_id']);
        for ($i=0; $i < $useridcount; $i++) { 
           $work_flow_level_user_id = DB::table('work_flow_level_user')->insertGetId([
            'work_flow_level_id' => $input['work_flow_level_id'],
            'user_id' => $input['user_id'][$i],
            'array_users' => $stringuser_id,
            'created_by' => auth()->user()->id,
            'created_at' => NOW()
        ]);

       //   $user_notification = DB::table('notifications')->insertGetId([
       //      'notification_type' => 'work flow',
       //      'notification_type_id' => $input['work_flow_level_id'],
       //      'user_id' => $input['user_id'][$i],
       //       'notification_status' => 0,
       //      'created_by' => auth()->user()->id,
       //      'created_at' => NOW()
       //  ]);


       }



       $settingsidcount = count($input['settings_id']);
       for ($i=0; $i < $settingsidcount; $i++) { 
           $work_flow_level_settings_id = DB::table('work_flow_level_settings')->insertGetId([
            'work_flow_level_id' => $input['work_flow_level_id'],
            'settings_id' => $input['settings_id'][$i],
            'array_settings' => $stringsettings_id,
            'day_count' =>$input['day_count'],
            'created_by' => auth()->user()->id,
            'created_at' => NOW()
        ]);
       }
       $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

    $role_name_fetch=$role_name[0]->role_name;
       $this->auditLog('work_flow_level', $input['work_flow_level_id'], 'Update', 'Update new work flow level', auth()->user()->id, NOW(),$role_name_fetch);
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


public function datacheck(Request $request)
{
  try {
    $method = 'Method => WorkFlowController => datacheck';
    $inputArray = $this->decryptData($request->requestData);
    $input = [
        'work_flow_id' => $inputArray['work_flow_id'],
    ];

    $work_flow_level = DB::table('work_flow_level as a')
    ->select('a.work_flow_id','a.work_flow_level_id','a.work_flow_level_name','a.stage_id','b.stage_name')
    ->join('work_flow_stage as b','b.stage_id','=','a.stage_id')
    ->where('a.work_flow_id',$input['work_flow_id'])
    ->get();




    $stage = DB::select('select * from work_flow_stage ');

    $initiatestage = DB::select('select * from work_flow_stage');





    $settings = DB::table('work_flow_settings as a')
    ->select('a.settings_id','a.settings_name','a.description','a.default_status')
    ->get();

    $user = DB::table('users as a')
    ->select('a.id','a.name','a.email')
    ->get();

    $work_flow_id = $input['work_flow_id'];

    $datacheked = DB::select("select c.array_users,d.array_settings,a.work_flow_id,b.work_flow_level_id,b.work_flow_level_name,b.stage_id,e.stage_name,c.user_id,d.settings_id,d.day_count from work_flow as a inner join work_flow_level as b on b.work_flow_id = a.work_flow_id inner join work_flow_level_user as c on 
        c.work_flow_level_id = b.work_flow_level_id inner join work_flow_level_settings as d on d.work_flow_level_id = b.work_flow_level_id inner join work_flow_stage as e on e.stage_id = b.stage_id where a.work_flow_id = '$work_flow_id'");



    return $this->sendnewResponse($work_flow_level,$stage,$user,$settings,$datacheked,$initiatestage);

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
    $method = 'Method => WorkFlowController => updatedata';
    $inputArray = $this->decryptData($request->requestData);
    $input = [
        'workflow_name' => $inputArray['workflow_name'],
        'description' => $inputArray['description'],
        'attachment' => $inputArray['attachment'],
        'work_flow_id' => $inputArray['work_flow_id']
    ];

    DB::transaction(function() use($input) {
        DB::table('work_flow')
        ->where('work_flow_id', $input['work_flow_id'])
        ->update([
            'work_flow_name' => $input['workflow_name'],
            'work_flow_description' => $input['description'],
            'work_flow_attachment' => $input['attachment'],
            'last_modified_by' => auth()->user()->id,
            'last_modified_date' => NOW()
        ]);
        $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

    $role_name_fetch=$role_name[0]->role_name;
        $this->auditLog('work_flow', $input['work_flow_id'] , 'Update', 'Update work flow', auth()->user()->id, NOW(),$role_name_fetch);
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


public function notification(Request $request)
{
  try {
    $method = 'Method => WorkFlowController => notification';
    $inputArray = $this->decryptData($request->requestData);
    $input = [
        'login_user_id' => $inputArray['login_user_id'],
    ];
    $user_id =  $input['login_user_id'];

// $rows =  DB::table('notifications')->groupBy('notification_type')->count();


    $rowscount = DB::select("select count(*) as countdata  from notifications where user_id = $user_id and notification_status = 0");

    $rowsdetails = DB::select("select a.notification_type, b.work_flow_level_name,c.work_flow_name,c.work_flow_id from notifications as a inner join work_flow_level as b on b.work_flow_level_id = a.notification_type_id
        inner join work_flow  as c on c.work_flow_id =  b.work_flow_id where  user_id = '$user_id' and notification_status = 0");



    $rows = [
        'rowsdetails' => $rowsdetails,
        'rowscount' => $rowscount,
    ];

    return $this->sendDataResponse($rows);

} catch(\Exception $exc){
    return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
}
}


public function notification_alert(Request $request)
{
  try {
    $method = 'Method => WorkFlowController => notification_alert';
    $inputArray = $this->decryptData($request->requestData);
    $input = [
        'login_user_id' => $inputArray['login_user_id'],
        'work_flow_id' => $inputArray['work_flow_id'],
    ];
    $user_id =  $input['login_user_id'];
    $work_flow_id =  $input['work_flow_id'];


    $delete =  DB::table('notifications')->where([['work_flow_id', $work_flow_id],['user_id',$user_id ]])->delete();

    $rows = DB::select("select * from uam_screens where work_flow_id =  '$work_flow_id' ");




    return $this->sendDataResponse($rows);

} catch(\Exception $exc){
    return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
}
}




public function data_edit($id)
{
    try{
        $method = 'Method => WorkFlowController => data_edit';
        $id = $this->decryptData($id);
        $one_row = DB::table('work_flow')
        ->select('*')
        ->where('work_flow_id', $id)
        ->get();

        $response = [
            'one_row' => $one_row,
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

   // return $id;
    
    try{
        $method = 'Method => WorkFlowController => data_delete';
        $id = $this->decryptData($id);

        ///echo json_encode($id);exit;
  $work_flow = DB::select("select * from uam_screens where work_flow_id = '$id'");

//echo json_encode($work_flow);exit;

  if (json_encode($work_flow) == '[]') {

//echo "fdsfsdffggdf";exit;
     DB::transaction(function() use($id){

            $work_flow_level = DB::select("select * from work_flow_level where work_flow_id = '$id'");
            $work_flow_level_idcount = count($work_flow_level);
            //echo $work_flow_level[0]->work_flow_level_id;exit;
            for ($j=0; $j< $work_flow_level_idcount; $j++) { 
               $work_flow_level_id  =  $work_flow_level[$j]->work_flow_level_id;
               $work_flow_level_id1  = DB::table('work_flow_level_settings')->where('work_flow_level_id', $work_flow_level_id)->delete();
               $work_flow_level_id2  = DB::table('work_flow_level_user')->where('work_flow_level_id', $work_flow_level_id)->delete();
               $work_flow_level_id3 = DB::table('work_flow_level')->where('work_flow_level_id', $work_flow_level_id)->delete();
           }

           $uam_modules_id =  DB::table('work_flow')
           ->where('work_flow_id', $id)
           ->delete();                  
       });


    $serviceResponse = array();
    $serviceResponse['Code'] = config('setting.status_code.success');
    $serviceResponse['Message'] = config('setting.status_message.success');
    $serviceResponse['Data'] = 1;
    $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
    $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
    return $sendServiceResponse;




    }

    else{
    

   // echo "bsd";exit;

    $serviceResponse = array();
    $serviceResponse['Code'] = 400;
    $serviceResponse['Message'] = config('setting.status_message.success');
    $serviceResponse['Data'] = 1;
    $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
    $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
    return $sendServiceResponse;




    }
           
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
