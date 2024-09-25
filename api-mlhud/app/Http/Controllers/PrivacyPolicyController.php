<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
use DB;
use File;
use Illuminate\Support\Str;




class PrivacyPolicyController extends BaseController
{

  



public function index($id)
{
    $method = 'Method => PrivacyPolicyController => index';

    try{

        $rows = DB::table('policy_publish')
        ->select('*')
        ->where('id', $id)
        ->get();


        $response = [
            'rows' => $rows,
            // 'one_rows' => $one_rows
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

public function upload($id)
{
    
    try{

        $method = 'Method => PrivacyPolicyController => index';
 

        // $one_rows = DB::table('uam_modules')
        // ->select('*')
        // ->where('module_id', $id)
        // ->get();



        $rows = DB::table('image_upload')
        ->select('*')
        ->where('id', $id)
        ->get();

        $response = [
            'rows' => $rows,
            // 'one_rows' => $one_rows
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

public function publish(Request $request)
{

  try {
    $method = 'Method => PrivacyPolicyController => publish';
    $inputArray = $this->decryptData($request->requestData);
    $input = [
        'policy_content' => $inputArray['policy_content'],
        
        'id' => $inputArray['id'],

    ];

    DB::transaction(function() use($input) {
        DB::table('policy_publish')
        ->where('id', $input['id'])
        ->update([
            'policy_content' => $input['policy_content'],
            
            'last_modified_by' => auth()->user()->id,
            'updated_at' => NOW()
        ]);
        $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

    $role_name_fetch=$role_name[0]->role_name;
        $this->auditLog('privacy_policy', $input['id'] , 'Update', 'Update privacy policy', auth()->user()->id, NOW(),$role_name_fetch);
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

public function imagepublish(Request $request)
{

  try {
    $method = 'Method => PrivacyPolicyController => imagepublish';
    $inputArray = $this->decryptData($request->requestData);

      $rows = DB::table('image_upload')
        ->select('*')
        ->where('id', '1')
       ->get();

    //     DB::transaction(function() use($rows) {
    //     DB::table('image_upload')
        
    //     ->insert([
    //         'login_image' =>$rows[0]->login_image,
    //         'main_logo' => $rows[0]->main_logo,
    //         'login_path' => $rows[0]->login_path,
    //         'mainlogo_path' => $rows[0]->mainlogo_path,
    //         'status'=>2,
    //         'last_modified_by' => auth()->user()->id,
    //         'updated_at' => NOW()
    //     ]);
       
    // });
        

    $input = [
         
        'id' => $inputArray['id'],
         'login_image' =>(isset($inputArray['login_image']))?$inputArray['login_image']:$rows[0]->login_image,

    

     'main_logo'=>(isset($inputArray['main_logo']))?$inputArray['main_logo']:$rows[0]->main_logo,

      'login_path'=>(isset($inputArray['login_path']))?$inputArray['login_path']:$rows[0]->login_path,

      'mainlogo_path'=>(isset($inputArray['mainlogo_path']))?$inputArray['mainlogo_path']:$rows[0]->mainlogo_path,

    ];

    DB::transaction(function() use($input) {
        DB::table('image_upload')
        ->where('id', $input['id'])
        ->update([
            'login_image' =>$input['login_image'],
            'main_logo' => $input['main_logo'],
            'login_path' => $input['login_path'],
            'mainlogo_path' => $input['mainlogo_path'],
            'last_modified_by' => auth()->user()->id,
            'updated_at' => NOW()
        ]);
        $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

    $role_name_fetch=$role_name[0]->role_name;
        $this->auditLog('image_upload', $input['id'] , 'Update', 'Updated the Dynamic Image', auth()->user()->id, NOW(),$role_name_fetch);
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

public function backgroundimage(Request $request)
{

  try {
    $method = 'Method => PrivacyPolicyController => backgroundimage';
    $inputArray = $this->decryptData($request->requestData);

      $input = [
        'backcolor' => $inputArray['backcolor'],
        
        'id' => $inputArray['id'],

    ];



    DB::transaction(function() use($input) {
        DB::table('image_upload')
        ->where('id', $input['id'])
        ->update([
            'bgcolor' =>$input['backcolor'],
            
            'last_modified_by' => auth()->user()->id,
            'updated_at' => NOW()
        ]);
        $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

    $role_name_fetch=$role_name[0]->role_name;
        $this->auditLog('image_upload', $input['id'] , 'Update', 'Background Color Updated', auth()->user()->id, NOW(),$role_name_fetch);
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

public function policy_screen()
{
    
    try{

        $method = 'Method => PrivacyPolicyController => policy_screen';
 

        // $one_rows = DB::table('uam_modules')
        // ->select('*')
        // ->where('module_id', $id)
        // ->get();



        $rows = DB::table('policy_publish')
        ->select('*')      
        ->get();




        $response = [
            'rows' => $rows,
            // 'one_rows' => $one_rows
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

public function login_bg()
{
    
    try{

        $method = 'Method => PrivacyPolicyController => login_bg';
 

        // $one_rows = DB::table('uam_modules')
        // ->select('*')
        // ->where('module_id', $id)
        // ->get();
        $rows = DB::table('image_upload')
        ->select('*')
       
        ->get();


        $response = [
            'rows' => $rows,
            // 'one_rows' => $one_rows
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








}
