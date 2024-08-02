<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendResetMail;
use App\Mail\SendUserCreateMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth;
use Illuminate\Support\Facades\Hash;


class   questionmastercontroller extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
   {
    try {
        $userID = auth()->user()->id;
        $method = 'Method => questionmastercontroller => get_data';
        
        
        $rows['question_master'] = DB::table('question_master as a')
       
        ->select('a.*')
        ->where ('a.active_flag', 0)       
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


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        try {
            $method = 'Method => General_registation => storedata';
            $inputArray = $request->requestData;
  // 		  $data['fname'] = $request->fname;

            $input = [
                'question' => $inputArray['question'],
               
            ];
            
            
            $email_check = DB::select("select * from question_master where   active_flag = '1'");
            if (json_encode($email_check) == '[]') { 
        
        
        
                DB::transaction(function() use($input) {
                    $role_id = DB::table('question_master')
                    ->insertGetId([
                        'question' => $input['question'],
                        
                        'active_flag' => 0,
                        'created_at' => NOW(),
                  
                    ]);
        
        
                   
        
                  //   $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                  //       INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);
        
                  //   $role_name_fetch=$role_name[0]->role_name;
                  //   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');
        
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function data_edit($id)
    {
        try{
    
            $method = 'Method => questionmastercontroller => data_edit';   
            $id = $this->decryptData($id);   
            $rows = DB::table('question_master as a')
            ->select('a.*')
            ->where('id', $id)
            ->get();
    
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
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatedata(Request $request)
{

    try {
      $method = 'Method =>  questionmastercontroller => updatedata';
      $inputArray = $this->decryptData($request->requestData);
      $input = [
          'question' => $inputArray['question'],
          'id' => $inputArray['id']
  
      ];
                  $question  =  $input['question'];
                  $id = $input['id']; 
                DB::transaction(function() use($input) {
                   DB::table('question_master')
                   ->where('id', $input['id'])
                   ->update([
                   'question' => $input['question'],
         
      ]);
    //   $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
    //       INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);
  
    //   $role_name_fetch=$role_name[0]->role_name;
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
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function data_delete($id)
    {
        try{

            $method = 'Method =>questionmastercontroller => data_delete';
            $id = $this->decryptData($id);   
                DB::table('question_master')
                ->where('id', $id)
                ->update([
                    'active_flag' => 1,
                    
                ]); 
    
                
    
                // $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                //     INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);
    
                // $role_name_fetch=$role_name[0]->role_name;
               
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
    
        //
    }
}
