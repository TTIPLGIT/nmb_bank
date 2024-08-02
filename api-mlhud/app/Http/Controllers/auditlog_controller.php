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
use Mockery\Undefined;


class auditlog_controller extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }
    public function uam(Request $request)
    {
        try {
            $method = 'Method => AuditLogController => get_data';
                // $rows = DB::table('operations_audit_logs as a')
                // ->select('a.*','users.name')
                // ->join('users', 'users.id', '=', 'a.user_id')
                // ->get();
            $rows = DB::table('audit_logs as a')
            ->select('a.*',)
            ->where('a.role_name','1')
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
        //
    }
    public function vreg(Request $request)
    {
        try {
            $method = 'Method => AuditLogController => get_data';
                // $rows = DB::table('operations_audit_logs as a')
                // ->select('a.*','users.name')
                // ->join('users', 'users.id', '=', 'a.user_id')
                // ->get();
            $rows = DB::table('audit_logs as a')
            ->select('a.*',)
            ->where('role_name','2')
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
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
