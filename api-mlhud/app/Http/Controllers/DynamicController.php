<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Str;


class DynamicController extends BaseController
{
  public function get_data()
  { 
    try {

      $method = 'Method => DynamicController => get_data';

      $rows = DB::select('SELECT c.screen_id,c.screen_name as screen_name,GROUP_CONCAT(d.listfieldname) as fields from dynamiclist_field as d
       inner join uam_screens as c on c.screen_id = d.screen_id
       where d.active_flag=0  GROUP BY screen_name,c.screen_id');



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
    $method = 'Method => DynamicController => getallscreens';



        // $modulesdata= DB::table('uam_modules')
        // ->whereNotIn('module_id', DB::table('uam_module_screens')->pluck('module_id'))
        // ->get();
    $getallscreens =  DB::select("SELECT distinct us.route_url,us.screen_name,us.screen_id FROM uam_screens AS us left JOIN dynamiclist_field df ON(df.screen_id = us.screen_id) WHERE df.screen_id IS null");


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
    $method = 'Method => DynamicController => storedata';
    $inputArray = $this->decryptData($request->requestData);

   // return $inputArray;

    $input = [
      'screen_id' => $inputArray['screen_id'],
      'field_name' => $inputArray['field_name'],
      'fieldlabelname'=> $inputArray['fieldlabelname'],

    ];

    $fieldidcount = $inputArray['field_name'];


    DB::transaction(function() use($input){ 

     $fieldidcount = count($input['field_name']);

     // $dynamic_arr=[];
     for ($i=0; $i < $fieldidcount; $i++) { 
      $dynamic_id = DB::table('dynamiclist_field')->insertGetId([
        'listfieldname' =>strtoupper($input['fieldlabelname'][$i]),
        'listfieldname_field_name' => $input['field_name'][$i],
        'screen_id' => $input['screen_id'],                                               
        'active_flag' => 0,
        'created_by' => auth()->user()->id,
        'created_date' => NOW()
      ]);
       // $dynamic_arr[$i]= $dynamic_id;
    }
    // $roles=DB::select("SELECT * from uam_roles where active_flag='0'");
    // for ($i=0; $i < count($roles); $i++) { 
    //     $dynamic_id = DB::table('dynamiclistallocation_field')->insertGetId([
    //         'dynamiclist_field_id' => $dynamic_arr[0],
    //        'role_id' => $roles[$i]->role_id,
    //         'screen_id' => $input['screen_id'],                                               
    //         'active_flag' => 0,
    //         'created_by' => auth()->user()->id,
    //         'created_date' => NOW()
    //     ]);
    //   }
    
    $role_name=DB::select("SELECT ur.role_name,us.name FROM uam_roles AS ur
      INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

    $role_name_fetch=$role_name[0]->role_name;
    $name=$role_name[0]->name;  

    $this->auditLog('dynamiclist_field', $dynamic_id, 'Create', "New screen mapping by $name", auth()->user()->id, NOW(),$role_name_fetch);
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

public function update_data(Request $request)
{
//return $request;
  try {
    $method = 'Method => DynamicController => update_data';
    $inputArray = $this->decryptData($request->requestData);

   // return $inputArray;

    $input = [
      'screen_id' => $inputArray['screen_id'],
      'field_name' => $inputArray['field_name'],
      'fieldlabelname'=> $inputArray['fieldlabelname'],

    ];
    $field_allocated=[];
    $field_details = DB::select("SELECT df.*,dff.listfieldname_field_name as listfieldname_field_name   FROM dynamiclistallocation_field as df 
      INNER JOIN dynamiclist_field dff ON (dff.dynamiclist_field_id=df.dynamiclist_field_id)
      WHERE df.active_flag='0' AND df.screen_id=".$input['screen_id']);
    foreach ($field_details as $key => $field_detail) {
      array_push($field_allocated, $field_detail->listfieldname_field_name);
    }

    // $fieldidcount = $inputArray['field_name'];
    // $fieldidcount1 = count($input['field_name']);
  
    // $result=array_intersect($field_allocated,$fieldidcount);
    
      DB::transaction(function() use($input,$field_allocated){ 
        if(!empty($field_allocated)){
        foreach ($field_allocated as $key => $field_allocat) {
        
          $rows1 = DB::table('dynamiclist_field')
          
           ->where([['screen_id', '=', $input['screen_id'] ],['listfieldname_field_name', '!=',$field_allocated]])
          ->delete();
           
        }
      }else
      {
         
           $uam_modules_id =  DB::table('dynamiclist_field')
               ->where('screen_id', $input['screen_id'])
               ->delete(); 
      }
     
       $fieldidcount = count($input['field_name']);

     // $dynamic_arr=[];
     for ($i=0; $i < $fieldidcount; $i++) { 
      $dynamic_id = DB::table('dynamiclist_field')->insertGetId([
        'listfieldname' =>strtoupper($input['fieldlabelname'][$i]),
        'listfieldname_field_name' => $input['field_name'][$i],
        'screen_id' => $input['screen_id'],                                               
        'active_flag' => 0,
        'created_by' => auth()->user()->id,
        'created_date' => NOW()
      ]);
       // $dynamic_arr[$i]= $dynamic_id;
    }

        $role_name=DB::select("SELECT ur.role_name,us.name FROM uam_roles AS ur
          INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

        $role_name_fetch=$role_name[0]->role_name;
        $name=$role_name[0]->name;  

        $this->auditLog('dynamiclist_field', $dynamic_id, 'Create', "New screen mapping by $name", auth()->user()->id, NOW(),$role_name_fetch);
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

public function data_edit($id1) 
{
  $logMethod = 'Method => DynamicController => data_edit';

  try {
    $id1 = $this->decryptData($id1);




    $screen_details = DB::select("select * from uam_screens where active_flag = 0 and screen_id=$id1");

    
    $field_details = DB::select("SELECT * FROM dynamiclist_field WHERE active_flag='0' AND screen_id=$id1 ");

     $field_mapped = DB::select("SELECT df.*,dff.listfieldname_field_name as listfieldname_field_name   FROM dynamiclistallocation_field as df 
      INNER JOIN dynamiclist_field dff ON (dff.dynamiclist_field_id=df.dynamiclist_field_id)
      WHERE df.active_flag='0' AND df.screen_id=".$id1);

    $response = [ 

      'screen_details' => $screen_details,
      'field_details' => $field_details,
      'field_mapped'=>$field_mapped


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

public function data_delete($id)
{
    try{

        $method = 'Method => DynamicController => data_delete';
        $id = $this->decryptData($id);
        $field_details = DB::select("SELECT df.*,dff.listfieldname_field_name as listfieldname_field_name   FROM dynamiclistallocation_field as df 
      INNER JOIN dynamiclist_field dff ON (dff.dynamiclist_field_id=df.dynamiclist_field_id)
      WHERE df.active_flag='0' AND df.screen_id=".$id);
        if(empty($field_details))
        {
        DB::transaction(function() use($id){
         $uam_modules_id =  DB::table('dynamiclist_field')
         ->where('screen_id', $id)
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
        else {
          $serviceResponse = array();
        $serviceResponse['Code'] = config('setting.status_code.validation');
        $serviceResponse['Message'] = config('setting.status_message.validation');
        $serviceResponse['Data'] = 1;
        $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
        $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.validation'), true);
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
