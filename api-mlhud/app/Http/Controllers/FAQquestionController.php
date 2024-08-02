<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Str;



class FAQquestionController extends BaseController
{

   public function get_data(Request $request)
   {       
    
    try {$userID = auth()->user()->id;
        $method = 'Method => FAQquestionController => get_data'; 
        $rows = DB::SELECT("select * from faq_ans as a inner join faq_modules_name as b on a.module_id=b.id where a.flag='0' ;");  
        
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

public function get_FAQ_question()
{
  
    try {
        $method = 'Method => FAQquestionController => get_FAQ_question';
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
     $this->WriteFileLog($exceptionResponse);
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
        $method = 'Method => FAQquestionController => storedata';
        $inputArray = $this->decryptData($request->requestData);
        $input = [
            'module_id' => $inputArray['module_id'],
            'question' => $inputArray['question'],
            'answer' => $inputArray['answer'],
        ];
                   //return auth()->user()->id;

        DB::transaction(function() use($input) {
            $manage_faq_id = DB::table('faq_ans')
            ->insertGetId([
                'module_id' => $input['module_id'],
                'question' => $input['question'],
                'answer' => $input['answer'],
                'user_id' => auth()->user()->id,

            ]);
    //          $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
    //                 INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);
    // $role_name_fetch=$role_name[0]->role_name;
    //         $this->auditLog('faq_questions', $manage_faq_id, 'Create', 'Create new manage FAQ', auth()->user()->id, NOW(),$role_name_fetch);
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
        $this->WriteFileLog($exceptionResponse);
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
    $method = 'Method => FAQquestionController => updatedata';
    $inputArray = $this->decryptData($request->requestData);
    $input = [
            'module_id' => $inputArray['module_id'],
            'question' => $inputArray['question'],
            'answer' => $inputArray['answer'],
            'que_id' => $inputArray['que_id'],
        ];

    DB::transaction(function() use($input) {
        DB::table('faq_ans')
        ->where('id', $input['que_id'])
        ->update([
            'module_id' => $input['module_id'],
            'question' => $input['question'],
            'answer' => $input['answer'],
            'user_id' => auth()->user()->id,
            'last_modified_by' => auth()->user()->id,
            'updated_at' => NOW()
        ]);
        $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

    $role_name_fetch=$role_name[0]->role_name;
        $this->auditLog('faq_question', $input['que_id'] , 'Update', 'Update Manage FAQ', auth()->user()->id, NOW(),$role_name_fetch);
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
   $this->WriteFileLog($exceptionResponse);
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

        $method = 'Method => FAQquestionController => data_edit';

        $id = $this->decryptData($id);
        $one_rows = DB::table('faq_ans')
        ->select('*')
        ->where('module_id', $id)
        ->get();      
        $rows = DB::table('faq_modules_name')
        ->select('*')
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
     $this->WriteFileLog($exceptionResponse);
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

        $method = 'Method => FAQquestionController => data_delete';
        $id = $this->decryptData($id);

     

        

             DB::transaction(function() use($id){
               $uam_modules_id =  DB::table('faq_ans')
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

          

    }catch(\Exception $exc){
     $exceptionResponse = array();
     $exceptionResponse['ServiceMethod'] = $method;
     $exceptionResponse['Exception'] = $exc->getMessage();
     $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
     $this->WriteFileLog($exceptionResponse);
     $serviceResponse = array();
     $serviceResponse['Code'] = config('setting.status_code.exception');
     $serviceResponse['Message'] = $exc->getMessage();
     $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
     $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
     return $sendServiceResponse;
 }
}

public function update_toggle(Request $request)
{
    try{

        $method = 'Method => FAQquestionController => update_toggle';
        $inputArray = $this->decryptData($request->requestData);
       $input = [
            'is_active' => $inputArray['is_active'],
            'f_id' => $inputArray['f_id'],
            
        ];

        
        DB::table('faq_ans')
                            
            ->where([['id', '=', $input['f_id']]])  
            ->update(['status'=> $input['is_active']]);




        $serviceResponse = array();
        $serviceResponse['Code'] = config('setting.status_code.success');
        $serviceResponse['Message'] = config('setting.status_message.success');
        $serviceResponse['Data'] = $input['is_active'];
        $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
        $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
        return $sendServiceResponse;            

    }catch(\Exception $exc){
     $exceptionResponse = array();
     $exceptionResponse['ServiceMethod'] = $method;
     $exceptionResponse['Exception'] = $exc->getMessage();
     $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
     $this->WriteFileLog($exceptionResponse);
     $serviceResponse = array();
     $serviceResponse['Code'] = config('setting.status_code.exception');
     $serviceResponse['Message'] = $exc->getMessage();
     $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
     $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
     return $sendServiceResponse;
 }
}

}
