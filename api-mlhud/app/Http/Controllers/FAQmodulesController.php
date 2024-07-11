<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Str;



class FAQmodulesController extends BaseController
{

   public function get_data(Request $request)
   {
      

    try {
        $method = 'Method => FAQmodulesController => get_data';
        // $rows = DB::table('faq_module_name as a')
       
        // ->select('a.module_name','a.id')
        // ->get();
       

        $rows=DB::select('select * from faq_modules_name ');

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
    //  $this->WriteFileLog();
     $serviceResponse = array();
     $serviceResponse['Code'] = config('setting.status_code.exception');
     $serviceResponse['Message'] = $exc->getMessage();
     $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
     $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
     return $sendServiceResponse;
 }
}
public function get_faq_data()
{ 
    try{

        $method = 'Method => FAQquestionsController => get_faq_data';
        $one_rows = DB::table('faq_modules_name')
        ->select('*')
        ->where ('status', 0)
        ->get();
        $rows = DB::table('faq_ans')
        ->select('*')
         ->where ('status', 0)
        ->get();
        $response = [
            'rows' => $rows,
            'one_rows' => $one_rows
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

public function get_search_ques(Request $request)
{
    try{

        $method = 'Method => FAQquestionsController => get_search_ques';

        $inputArray = $this->decryptData($request->requestData);

        $input = [
            'module_name' => $inputArray['module_name'],
            
        ];

        
        $rows = DB::select("Select * from faq_modules_name where status='0' and module_name LIKE '". $input['module_name']."%'");


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
public function get_search_ans(Request $request)
{
    try{

        $method = 'Method => FAQquestionsController => get_search_ans';
        $inputArray = $this->decryptData($request->requestData);
       $input = [
            'mod_id' => $inputArray['mod_id'],
            
        ];

        
        $rows = DB::select("Select * from faq_ans   where status='0' and module_id LIKE '". $input['mod_id']."%'");



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


public function get_FAQ_modules()
{
    try {
        $method = 'Method => FAQmodulesController => get_FAQ_modules';
        $rows = DB::table('faq_modules_name')
        ->select('*')
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
    $userID = auth()->user()->id;
    try {
        $method = 'Method => FAQmodulesController => storedata';
        $inputArray = $this->decryptData($request->requestData);
        $input = [
            'module_name' => $inputArray['module_name'],
            
        ];

                   //return auth()->user()->id;

        DB::transaction(function() use($input) {
            $uam_modules_id = DB::table('faq_modules_name')
            ->insertGetId([
                'module_name' => $input['module_name'],
                'user_id'=>auth()->user()->id,
                
                

            ]);
             $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

    $role_name_fetch=$role_name[0]->role_name;
            $this->auditLog('FAQ_modules', $uam_modules_id, 'Create', 'Create new FAQ module', auth()->user()->id, NOW(),$role_name_fetch);
        });

// return $this->sendResponse('Success', 'Uam module update successfully.');

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
    $method = 'Method => FAQmodulesController => updatedata';
    $inputArray = $this->decryptData($request->requestData);
    $input = [
        'module_name' => $inputArray['module_name'],
        
        'id' => $inputArray['id'],

    ];

    DB::transaction(function() use($input) {
        DB::table('faq_modules_name')
        ->where('id', $input['id'])
        ->update([
            'module_name' => $input['module_name'],
            
            'last_modified_by' => auth()->user()->id,
            'updated_at' => NOW()
        ]);
        $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

    $role_name_fetch=$role_name[0]->role_name;
        $this->auditLog('FAQ_modules', $input['id'] , 'Update', 'Update FAQ module', auth()->user()->id, NOW(),$role_name_fetch);
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

        $method = 'Method => FAQmodulesController => data_edit';

        $id = $this->decryptData($id);

        // $one_rows = DB::table('uam_modules')
        // ->select('*')
        // ->where('module_id', $id)
        // ->get();

        $rows = DB::table('faq_modules_name')
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




public function data_delete($id)
{
    try{

        $method = 'Method => FAQmodulesController => data_delete';
        $id = $this->decryptData($id);
  $check = DB::select("select * from faq_ans where module_id = '$id'");

        if ($check == []) { 
   

            DB::transaction(function() use($id){
               $uam_modules_id =  DB::table('faq_modules_name')
               ->where('id', $id)
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
