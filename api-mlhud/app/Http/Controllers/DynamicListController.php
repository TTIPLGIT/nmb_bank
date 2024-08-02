<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
use DB;
use File;
use Illuminate\Support\Str;


class DynamicListController extends BaseController
{
  public function get_data(Request $request)
  { 
    try {
      $method = 'Method => DynamicListController => get_data';
      $where_que=($request->dynamiclist=="dynamiclist")?"or 1=1":"";
      $rows = DB::select('SELECT ur.role_id,c.screen_id,ur.role_name as role,c.screen_name as screen_name,GROUP_CONCAT(d.listfieldname) as fields from dynamiclistallocation_field as a
       inner join uam_screens as c on c.screen_id = a.screen_id
       inner join dynamiclist_field as d ON d.dynamiclist_field_id = a.dynamiclist_field_id
       inner join uam_roles as ur ON ur.role_id = a.role_id where a.active_flag=0 '.$where_que.' GROUP BY screen_name,role,ur.role_id,c.screen_id');



      $response = [  
        'rows' => $rows,

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
 public function getallscreens()
 {


  try {
    $method = 'Method => DynamicListController => getallscreens';



        // $modulesdata= DB::table('uam_modules')
        // ->whereNotIn('module_id', DB::table('uam_module_screens')->pluck('module_id'))
        // ->get();
    $getallscreens =  DB::select("select distinct c.screen_id,c.route_url,c.screen_name from dynamiclist_field as a 
      inner join uam_screens as c on c.screen_id = a.screen_id
      where c.active_flag = '0'");

    $getallrole =  DB::select("select * from uam_roles
     where active_flag = '0'");
        // $getallscreens = DB::table('dynamiclist_field as a')
        // ->join('uam_screens as b', 'b.screen_id', '=', 'a.screen_id')
        // ->select('b.screen_id','b.route_url')
        // ->where('b.active_flag',0)
        // ->get();


    $response = [
      'getallscreens' => $getallscreens,
      'getallrole'=>$getallrole

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
//return $request;
  try {
    $method = 'Method => DynamicListController => storedata';
    $inputArray = $this->decryptData($request->requestData);

   // return $inputArray;

    $input = [
      'screen_id' => $inputArray['screen_id'],
      'field_id' => $inputArray['field_id'],
      'role_id'=>$inputArray['role_id']


    ];

    $fieldidcount = $inputArray['field_id'];

    // DB::transaction(function() use($id){
    //    $uam_modules_id =  DB::table('work_flow_settings')
    //                 ->where('settings_id', $id)
    //                 ->delete();                  
    //             });
    


    DB::transaction(function() use($input){

     $fieldidcount = count($input['field_id']);

     for ($i=0; $i < $fieldidcount; $i++) { 
      $dynamic_id = DB::table('dynamiclistallocation_field')->insertGetId([
        'dynamiclist_field_id' => $input['field_id'][$i],
        'role_id'=>$input['role_id'],
        'screen_id' => $input['screen_id'],                                               
        'active_flag' => 0,
        'created_by' => auth()->user()->id,
        'created_date' => NOW()
      ]);
    }
    
    $role_name=DB::select("SELECT ur.role_name,us.name FROM uam_roles AS ur
      INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

    $role_name_fetch=$role_name[0]->role_name;
    $name=$role_name[0]->name;  

    $this->auditLog('dynamiclist_field', $dynamic_id, 'Create', "New Field mapping by $name", auth()->user()->id, NOW(),$role_name_fetch);
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
public function getalldynamicfield(Request $request)
{
  $logMethod = 'Method => DynamicListController => getalldynamicfield';
  try {
    $inputArray = $this->DecryptData($request->requestData);
    $input = [
      'screen_id' => $inputArray['screen_id'],
    ];

    $rules = [
      'screen_id' => 'required | numeric',
    ];
    
    $messages = [
      'screen_id.required' => 'Screen ID is required.'
    ];

    $validator = Validator::make($input, $rules, $messages);

    if($validator->fails()) {
      $serviceResponse = array();
      $serviceResponse['Code'] = config('setting.status_code.validation');
      $serviceResponse['Message'] = $validator->errors()->first();
      $serviceResponse = json_encode($serviceResponse);
      $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.validation'), false);
      return $sendServiceResponse;
    }

    $screen_id=$input['screen_id'];

    $getallscreens =  DB::select("select a.* from dynamiclist_field as a 

     where a.screen_id = '$screen_id' and a.active_flag = '0'");

    $response = [
      'getallscreens' => $getallscreens

    ];

    $serviceResponse = array();
    $serviceResponse['Code'] = config('setting.status_code.success');
    $serviceResponse['Message'] = config('setting.status_message.success');
    $serviceResponse['Data'] = $response;
    $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
    $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
    return $sendServiceResponse;
  } catch (\Exception $exc) {
    $exceptionResponse = array();
    $exceptionResponse['ServiceMethod'] = $logMethod;
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

public function getmodule(Request $request)
{
  $logMethod = 'Method => DynamicListController => getmodule';
  try {
    $inputArray = $this->DecryptData($request->requestData);
    $input = [
      'role_id' => $inputArray['role_id'],
    ];

    $rules = [
      'role_id' => 'required | numeric',
    ];
    
    $messages = [
      'role_id.required' => 'Role ID is required.'
    ];

    $validator = Validator::make($input, $rules, $messages);

    if($validator->fails()) {
      $serviceResponse = array();
      $serviceResponse['Code'] = config('setting.status_code.validation');
      $serviceResponse['Message'] = $validator->errors()->first();
      $serviceResponse = json_encode($serviceResponse);
      $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.validation'), false);
      return $sendServiceResponse;
    }

    $role_id=$input['role_id'];

    // $getallscreens =  DB::select("select distinct c.screen_id,c.route_url,c.screen_name from dynamiclist_field as a 
    //     inner join uam_screens as c on c.screen_id = a.screen_id
    //     inner join dynamiclistallocation_field as d on d.screen_id = c.screen_id
    //    WHERE d.role_id IN($role_id) AND d.active_flag='0'");
    $getscreen_id=[];
    $getscreens=DB::select("SELECT DISTINCT df.screen_id FROM dynamiclistallocation_field AS df WHERE df.role_id=".$role_id);
    if (!empty($getscreens))
    {
      foreach ($getscreens as $key => $getscreen) {
        array_push($getscreen_id, $getscreen->screen_id);
      }
      $get_screen_id=implode(",",$getscreen_id);
      $getallscreens =  DB::select("select DISTINCT d.role_id,c.screen_id,c.route_url,c.screen_name from dynamiclist_field as a 
        inner join uam_screens as c on c.screen_id = a.screen_id
        left join dynamiclistallocation_field as d ON (d.screen_id = c.screen_id) WHERE d.screen_id not IN(".$get_screen_id.") or d.role_id IS null");
    }
    else
    {
     $getallscreens=DB::select("SELECT DISTINCT df.screen_id,c.screen_id,c.route_url,c.screen_name FROM dynamiclist_field AS df
      inner join uam_screens as c on c.screen_id = df.screen_id");

   }








   $serviceResponse = array();
   $serviceResponse['Code'] = config('setting.status_code.success');
   $serviceResponse['Message'] = config('setting.status_message.success');
   $serviceResponse['Data'] = $getallscreens;
   $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
   $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
   return $sendServiceResponse;
 } catch (\Exception $exc) {
  $exceptionResponse = array();
  $exceptionResponse['ServiceMethod'] = $logMethod;
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

public function data_edit($id1,$id2) 
{
  $logMethod = 'Method => DynamicListController => data_edit';

  try {
    $id1 = $this->decryptData($id1);
    $id2 = $this->decryptData($id2);
    $role_details = DB::select("select * from uam_roles where active_flag = 0 and role_id=$id1");


    $screen_details = DB::select("select * from uam_screens where active_flag = 0 and screen_id=$id2");

    $allfields = DB::select("SELECT * FROM dynamiclist_field WHERE active_flag='0' AND screen_id=$id2");
    $field_details = DB::select("SELECT * FROM dynamiclistallocation_field WHERE active_flag='0' AND screen_id=$id2 AND role_id=$id1");

    $response = [ 
      'role_details' => $role_details,
      'screen_details' => $screen_details,
      'field_details' => $field_details,
      'allfields'=>$allfields

    ];

    $serviceResponse = array();
    $serviceResponse['Code'] = config('setting.status_code.success');
    $serviceResponse['Message'] = config('setting.status_message.success');
    $serviceResponse['Data'] = $response;
    $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
    $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
    return $sendServiceResponse;
  } catch (\Exception $exc) {
    $exceptionResponse = array();
    $exceptionResponse['ServiceMethod'] = $logMethod;
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

public function data_delete($id1,$id2)
{
  try{

    $method = 'Method => DynamicListController => data_delete';
    $id1 = $this->decryptData($id1);
    $id2 = $this->decryptData($id2);

    DB::transaction(function() use($id1,$id2){
     DB::table('dynamiclistallocation_field')
     ->where([['screen_id', '=', $id2 ],['role_id', '=', $id1 ]])
     ->delete();                  
   });

    $role_name=DB::select("SELECT ur.role_name,us.name FROM uam_roles AS ur
      INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

    $role_name_fetch=$role_name[0]->role_name;
    $name=$role_name[0]->name;  



    $this->auditLog('dynamic_list', $id1, 'Delete', "Delete module by $name", auth()->user()->id, NOW(),$role_name_fetch);

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


public function update_data(Request $request)
{
//return $request;

  try {
    $method = 'Method => DynamicListController => update_data';
    $inputArray = $this->decryptData($request->requestData);

   // return $inputArray;

    $input = [
      'screen_id' => $inputArray['screen_id'],
      'field_id' => $inputArray['field_id'],
      'role_id'=>$inputArray['role_id']


    ];

    $fieldidcount = $inputArray['field_id'];

    DB::transaction(function() use($input){
     $uam_modules_id =  DB::table('dynamiclistallocation_field')
     ->where([['screen_id', '=', $input['screen_id'] ],['role_id', '=', $input['role_id'] ]])
     ->delete();                  
   });
    


    DB::transaction(function() use($input){

     $fieldidcount = count($input['field_id']);

     for ($i=0; $i < $fieldidcount; $i++) { 
      $dynamic_id = DB::table('dynamiclistallocation_field')->insertGetId([
        'dynamiclist_field_id' => $input['field_id'][$i],
        'role_id'=>$input['role_id'],
        'screen_id' => $input['screen_id'],                                               
        'active_flag' => 0,
        'created_by' => auth()->user()->id,
        'created_date' => NOW()
      ]);
    }
    
    $role_name=DB::select("SELECT ur.role_name,us.name FROM uam_roles AS ur
      INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

    $role_name_fetch=$role_name[0]->role_name;
    $name=$role_name[0]->name;  

    $this->auditLog('dynamiclist_field', $dynamic_id, 'Update', "Updated the Field mapping by $name", auth()->user()->id, NOW(),$role_name_fetch);
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



}
