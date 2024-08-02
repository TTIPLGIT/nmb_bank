<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
use DB;
use File;
use Illuminate\Support\Str;
use Log;



class ReportController extends BaseController
{

 public function get_data()
 {
  try {
    $method = 'Method => ReportController => get_data';
        // $rows = DB::table('operations_audit_logs as a')
        // ->select('a.*','users.name')
        // ->join('users', 'users.id', '=', 'a.user_id')
        // ->get();
    $rows1 = DB::table('users as a')
    ->select('a.*',)
    ->where('a.active_flag',0)

    ->get();
    $rows=[];
    $response = [
      'rows1' => $rows1,
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
public function get_login()
{
  try {
    $method = 'Method => ReportController => get_login';
        // $rows = DB::table('operations_audit_logs as a')
        // ->select('a.*','users.name')
        // ->join('users', 'users.id', '=', 'a.user_id')
        // ->get();
    $rows1 = DB::table('users as a')
    ->select('a.*',)
    ->where('a.active_flag',0)

    ->get();
    $rows=[];
    $response = [
      'rows1' => $rows1,
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
public function get_userrole()
{
  try {
    $method = 'Method => ReportController => get_userrole';
        // $rows = DB::table('operations_audit_logs as a')
        // ->select('a.*','users.name')
        // ->join('users', 'users.id', '=', 'a.user_id')
        // ->get();
    $rows1 = DB::table('users as a')
    ->select('a.*',)
    ->where('a.active_flag',0)
    ->get();
    $rows=[];
    $response = [
      'rows1' => $rows1,
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
public function get_process()
{
  try {

    $method = 'Method => ReportController => get_process';
        // $rows = DB::table('operations_audit_logs as a')
        // ->select('a.*','users.name')
        // ->join('users', 'users.id', '=', 'a.user_id')
        // ->get();
    $rows1 = DB::table('users as a')
    ->select('a.*',)
    ->where('a.active_flag',0)
    ->get();
    $rows=[];
    $response = [
      'rows1' => $rows1,
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
public function get_newdoc()
{
  try {

    $method = 'Method => ReportController => get_newdoc';
        // $rows = DB::table('operations_audit_logs as a')
        // ->select('a.*','users.name')
        // ->join('users', 'users.id', '=', 'a.user_id')
        // ->get();
    $rows1 = DB::table('users as a')
    ->select('a.*',)
    ->where('a.active_flag',0)
    ->get();
    $rows=[];
    $response = [
      'rows1' => $rows1,
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
public function get_deletedoc()
{
  try {

    $method = 'Method => ReportController => get_deletedoc';
        // $rows = DB::table('operations_audit_logs as a')
        // ->select('a.*','users.name')
        // ->join('users', 'users.id', '=', 'a.user_id')
        // ->get();
    $rows1 = DB::table('users as a')
    ->select('a.*',)
    ->where('a.active_flag',0)
    ->get();
    $rows=[];
    $response = [
      'rows1' => $rows1,
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
public function get_archivedoc()
{
  try {

    $method = 'Method => ReportController => get_archivedoc';
        // $rows = DB::table('operations_audit_logs as a')
        // ->select('a.*','users.name')
        // ->join('users', 'users.id', '=', 'a.user_id')
        // ->get();
    $rows1 = DB::table('users as a')
    ->select('a.*',)
    ->where('a.active_flag',0)
    ->get();
    $rows=[];
    $response = [
      'rows1' => $rows1,
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
public function get_processedoc()
{
  try {

    $method = 'Method => ReportController => get_processedoc';
        // $rows = DB::table('operations_audit_logs as a')
        // ->select('a.*','users.name')
        // ->join('users', 'users.id', '=', 'a.user_id')
        // ->get();
    $rows1 = DB::table('users as a')
    ->select('a.*',)
    ->where('a.active_flag',0)
    ->get();
    $rows=[];
    $response = [
      'rows1' => $rows1,
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
public function get_grouped()
{
  try {

    $method = 'Method => ReportController => get_grouped';
        // $rows = DB::table('operations_audit_logs as a')
        // ->select('a.*','users.name')
        // ->join('users', 'users.id', '=', 'a.user_id')
        // ->get();
    $rows1 = DB::table('users as a')
    ->select('a.*',)

    ->get();
    $rows=[];
    $response = [
      'rows1' => $rows1,
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
public function get_awaiting_auth()
{
  try {

    $method = 'Method => ReportController => get_awaiting_auth';
        // $rows = DB::table('operations_audit_logs as a')
        // ->select('a.*','users.name')
        // ->join('users', 'users.id', '=', 'a.user_id')
        // ->get();
    $rows1 = DB::table('users as a')
    ->select('a.*',)
    ->where('a.active_flag',0)
    ->get();
    $rows=[];
    $response = [
      'rows1' => $rows1,
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


public function Search(Request $request)
{

  $logMethod = 'Method => ReportController => Index';
  try {           
    $inputArray = $this->decryptData($request->requestData);

    $user_id = $inputArray['user_id'];

    $receipt_no = $inputArray['receipt_no'];            
    $received_for = $inputArray['received_for'];

            $source_type = $inputArray['source_type'];//return $name;
            $uam_action = $inputArray['uam_action'];
            $workflow_action = $inputArray['workflow_action']; 
            $form_action = $inputArray['form_action'];
            $department_action = $inputArray['department_action'];



            if($receipt_no !=''){
              $receipt_no1=date('Y-m-d', strtotime($receipt_no)); 
            }
            else
            {
              $receipt_no1='';
            }
            if($received_for !=''){
              $receipt_no2=date('Y-m-d', strtotime($received_for)); 
            }
            else
            { 
              $receipt_no2='';
            }
            if (((($user_id !='') && ($source_type =='')) && (($receipt_no !='') && ($received_for !=''))) && ($source_type =='')) {
              $rows=DB::select("SELECT concat('documentprocess','#',fa.audit_id) as audit_id,us.name,'Document Process' AS module_name,(CASE WHEN fa.status_desc = 'Approved' THEN 'Uploaded' ELSE fa.status_desc END) AS ACTION,date_format(fa.process_date,'%d-%m-%Y & %h:%i:%s') AS action_date,fa.role_name FROM formprocessing_audit AS fa INNER JOIN users us ON (us.id=fa.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
                WHERE DATE_FORMAT(fa.process_date,'%Y-%m-%d') >='".$receipt_no1."' AND date_format(fa.process_date,'%Y-%m-%d')   <= '".$receipt_no2."' and us.email LIKE '".$user_id."%'
                UNION ALL
                SELECT concat('department','#',da.audit_id) as audit_id,us.name,'Department' AS module_name,da.action AS ACTION,date_format(da.process_date,'%d-%m-%Y & %h:%i:%s') AS action_date,da.role_name FROM department_audit AS da INNER JOIN users us ON (us.id=da.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
                WHERE DATE_FORMAT(da.process_date,'%Y-%m-%d') >='".$receipt_no1."' AND date_format(da.process_date,'%Y-%m-%d')   <= '".$receipt_no2."' and us.email LIKE '".$user_id."%'
                UNION ALL
                SELECT concat('workflow','#',wa.id) as audit_id,us.name,'Workflow' AS module_name,wa.description AS action,date_format(wa.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,wa.role_name  FROM operations_audit_logs AS wa 
                INNER JOIN users us ON (us.id=wa.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
                WHERE DATE_FORMAT(wa.action_date_time,'%Y-%m-%d') >='".$receipt_no1."' AND date_format(wa.action_date_time,'%Y-%m-%d')   <= '".$receipt_no2."' and us.email LIKE '".$user_id."%'
                UNION ALL
                SELECT concat('UAM','#',al.id) as audit_id,us.name,'UAM' AS module_name,Al.description as ACTION,date_format(Al.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,Al.role_name  FROM audit_logs Al INNER JOIN users us on(us.id=al.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
                WHERE DATE_FORMAT(Al.action_date_time,'%Y-%m-%d') >='".$receipt_no1."' AND date_format(Al.action_date_time,'%Y-%m-%d')   <= '".$receipt_no2."' and us.email LIKE '".$user_id."%'");
            }
            else if (((($user_id !='') && ($source_type =='')) || (($receipt_no !='') xor ($received_for !=''))) && ($source_type =='')) {
              $rows=DB::select("SELECT concat('documentprocess','#',fa.audit_id) as audit_id,us.name,'Document Process' AS module_name,(CASE WHEN fa.status_desc = 'Approved' THEN 'Uploaded' ELSE fa.status_desc END) AS ACTION,date_format(fa.process_date,'%d-%m-%Y & %h:%i:%s') AS action_date,fa.role_name FROM formprocessing_audit AS fa INNER JOIN users us ON (us.id=fa.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
                WHERE date_format(fa.process_date,'%Y-%m-%d') LIKE '".$receipt_no1."%' and date_format(fa.process_date,'%Y-%m-%d') LIKE '".$receipt_no2."%' and us.email LIKE '".$user_id."%'
                UNION ALL
                SELECT concat('department','#',da.audit_id) as audit_id,us.name,'Department' AS module_name,da.action AS ACTION,date_format(da.process_date,'%d-%m-%Y & %h:%i:%s') AS action_date,da.role_name FROM department_audit AS da INNER JOIN users us ON (us.id=da.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
                WHERE date_format(da.process_date,'%Y-%m-%d') LIKE '".$receipt_no1."%' and date_format(da.process_date,'%Y-%m-%d') LIKE '".$receipt_no2."%' and us.email LIKE '".$user_id."%'
                UNION ALL
                SELECT concat('workflow','#',wa.id) as audit_id,us.name,'Workflow' AS module_name,wa.description AS action,date_format(wa.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,wa.role_name  FROM operations_audit_logs AS wa 
                INNER JOIN users us ON (us.id=wa.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
                WHERE date_format(wa.action_date_time,'%Y-%m-%d') LIKE '".$receipt_no1."%'  and date_format(wa.action_date_time,'%Y-%m-%d') LIKE '".$receipt_no2."%' and us.email LIKE '".$user_id."%'
                UNION ALL
                SELECT concat('UAM','#',al.id) as audit_id,us.name,'UAM' AS module_name,Al.description as ACTION,date_format(Al.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,Al.role_name  FROM audit_logs Al INNER JOIN users us on(us.id=al.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
                WHERE date_format(Al.action_date_time,'%Y-%m-%d') LIKE '".$receipt_no1."%' and date_format(Al.action_date_time,'%Y-%m-%d') LIKE '".$receipt_no2."%' and us.email LIKE '".$user_id."%'");
            }


            else if(($source_type !='') && (($receipt_no !='') xor ($received_for !=''))){

              if($source_type =='Document Process'){


                $rows=DB::select("SELECT concat('documentprocess','#',fa.audit_id) as audit_id,us.name,'Document Process' AS module_name,(CASE WHEN fa.status_desc = 'Approved' THEN 'Uploaded' ELSE fa.status_desc END) AS ACTION,date_format(fa.process_date,'%d-%m-%Y & %h:%i:%s') AS action_date,fa.role_name FROM formprocessing_audit AS fa INNER JOIN users us ON (us.id=fa.user_id)
                  INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)WHERE date_format(fa.process_date,'%Y-%m-%d') LIKE '".$receipt_no1."%'  and us.email LIKE '".$user_id."%' and date_format(fa.process_date,'%Y-%m-%d') LIKE '".$receipt_no2."%' and fa.status_desc LIKE '".$form_action."%' ");

              }
              if($source_type =='Work Flow')
              {

                $rows=DB::select("
                  SELECT concat('workflow','#',wa.id) as audit_id,us.name,'Workflow' AS module_name,wa.description AS ACTION,date_format(wa.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,wa.role_name  FROM operations_audit_logs AS wa 
                  INNER JOIN users us ON (us.id=wa.user_id)
                  INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)WHERE date_format(wa.action_date_time,'%Y-%m-%d') LIKE '".$receipt_no1."%'  and date_format(wa.action_date_time,'%Y-%m-%d') LIKE '".$receipt_no2."%' and us.email LIKE '".$user_id."%' and wa.audit_action LIKE '".$workflow_action."%' 
                  ");

              }
              if($source_type =='UAM'){


                $rows=DB::select("SELECT concat('UAM','#',al.id) as audit_id,us.name,'UAM' AS module_name,Al.description as ACTION,date_format(Al.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,Al.role_name  FROM audit_logs Al INNER JOIN users us on(us.id=al.user_id)
                 INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)WHERE date_format(Al.action_date_time,'%Y-%m-%d') LIKE '".$receipt_no1."%'  and us.email LIKE '".$user_id."%' and date_format(Al.action_date_time,'%Y-%m-%d') LIKE '".$receipt_no2."%' and Al.audit_action LIKE '".$uam_action."%' ");

              }

              if($source_type =='Department'){


                $rows=DB::select("SELECT concat('department','#',da.audit_id) as audit_id,us.name,'Department' AS module_name,da.action AS ACTION,date_format(da.process_date,'%d-%m-%Y & %h:%i:%s') AS action_date,da.role_name FROM department_audit AS da INNER JOIN users us ON (us.id=da.user_id)
                  INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
                  WHERE date_format(da.process_date,'%Y-%m-%d') LIKE '".$receipt_no1."%'  and us.email LIKE '".$user_id."%' and date_format(da.process_date,'%Y-%m-%d') LIKE '".$receipt_no2."%' and da.status_desc LIKE '".$department_action."%' ");

              }
            }

            else if(($source_type !='') && ($receipt_no !='') && ($received_for !='')){

              if($source_type =='Document Process'){


               $rows=DB::select("SELECT concat('documentprocess','#',fa.audit_id) as audit_id,us.name,'Document Process' AS module_name,(CASE WHEN fa.status_desc = 'Approved' THEN 'Uploaded' ELSE fa.status_desc END) AS ACTION,date_format(fa.process_date,'%d-%m-%Y & %h:%i:%s') AS action_date,fa.role_name FROM formprocessing_audit AS fa INNER JOIN users us ON (us.id=fa.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)WHERE DATE_FORMAT(fa.process_date,'%Y-%m-%d') >='".$receipt_no1."' AND date_format(fa.process_date,'%Y-%m-%d')   <= '".$receipt_no2."' and us.email LIKE '".$user_id."%' and fa.status_desc LIKE '".$form_action."%' ");

             }
             if($source_type =='Work Flow')
             {

              $rows=DB::select("
                SELECT concat('workflow','#',wa.id) as audit_id,us.name,'Workflow' AS module_name,wa.description AS ACTION,date_format(wa.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,wa.role_name  FROM operations_audit_logs AS wa 
                INNER JOIN users us ON (us.id=wa.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)WHERE  DATE_FORMAT(wa.action_date_time,'%Y-%m-%d') >='".$receipt_no1."' AND date_format(wa.action_date_time,'%Y-%m-%d')   <= '".$receipt_no2."' and us.email LIKE '".$user_id."%' and wa.audit_action LIKE '".$workflow_action."%' 
                ");

            }
            if($source_type =='UAM'){


              $rows=DB::select("SELECT concat('UAM','#',al.id) as audit_id,us.name,'UAM' AS module_name,Al.description as ACTION,date_format(Al.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,Al.role_name  FROM audit_logs Al INNER JOIN users us on(us.id=al.user_id)
               INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)WHERE DATE_FORMAT(Al.action_date_time,'%Y-%m-%d') >='".$receipt_no1."' AND date_format(Al.action_date_time,'%Y-%m-%d')   <= '".$receipt_no2."'  and us.email LIKE '".$user_id."%' and Al.audit_action LIKE '".$uam_action."%' ");

            }
            if($source_type =='Department'){


              $rows=DB::select("SELECT concat('department','#',da.audit_id) as audit_id,us.name,'Department' AS module_name,da.action AS ACTION,date_format(da.process_date,'%d-%m-%Y & %h:%i:%s') AS action_date,da.role_name FROM department_audit AS da INNER JOIN users us ON (us.id=da.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
                WHERE date_format(da.process_date,'%Y-%m-%d') LIKE '".$receipt_no1."%'  and us.email LIKE '".$user_id."%' and date_format(da.process_date,'%Y-%m-%d') LIKE '".$receipt_no2."%' and da.status_desc LIKE '".$department_action."%' ");

            }
          }
          else if ((($source_type =='') && (($receipt_no !='') && ($received_for !=''))) && ($source_type =='')) {
            $rows=DB::select("SELECT concat('documentprocess','#',fa.audit_id) as audit_id,us.name,'Document Process' AS module_name,(CASE WHEN fa.status_desc = 'Approved' THEN 'Uploaded' ELSE fa.status_desc END) AS ACTION,date_format(fa.process_date,'%d-%m-%Y & %h:%i:%s') AS action_date,fa.role_name FROM formprocessing_audit AS fa INNER JOIN users us ON (us.id=fa.user_id)
              INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
              WHERE DATE_FORMAT(fa.process_date,'%Y-%m-%d') >='".$receipt_no1."' AND date_format(fa.process_date,'%Y-%m-%d')   <= '".$receipt_no2."' and us.email LIKE '".$user_id."%'
              UNION ALL
              SELECT concat('department','#',da.audit_id) as audit_id,us.name,'Department' AS module_name,da.action AS ACTION,date_format(da.process_date,'%d-%m-%Y & %h:%i:%s') AS action_date,da.role_name FROM department_audit AS da INNER JOIN users us ON (us.id=da.user_id)
              INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
              WHERE DATE_FORMAT(da.process_date,'%Y-%m-%d') >='".$receipt_no1."' AND date_format(da.process_date,'%Y-%m-%d')   <= '".$receipt_no2."' and us.email LIKE '".$user_id."%'
              UNION ALL
              SELECT concat('workflow','#',wa.id) as audit_id,us.name,'Workflow' AS module_name,wa.description AS action,date_format(wa.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,wa.role_name  FROM operations_audit_logs AS wa 
              INNER JOIN users us ON (us.id=wa.user_id)
              INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
              WHERE DATE_FORMAT(wa.action_date_time,'%Y-%m-%d') >='".$receipt_no1."' AND date_format(wa.action_date_time,'%Y-%m-%d')   <= '".$receipt_no2."' and us.email LIKE '".$user_id."%'
              UNION ALL
              SELECT concat('UAM','#',al.id) as audit_id,us.name,'UAM' AS module_name,Al.description as ACTION,date_format(Al.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,Al.role_name  FROM audit_logs Al INNER JOIN users us on(us.id=al.user_id)
              INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
              WHERE DATE_FORMAT(Al.action_date_time,'%Y-%m-%d') >='".$receipt_no1."' AND date_format(Al.action_date_time,'%Y-%m-%d')   <= '".$receipt_no2."' and us.email LIKE '".$user_id."%'");
          }
          else if(($source_type !='')){

            if($source_type =='Document Process'){


              $rows=DB::select("SELECT concat('documentprocess','#',fa.audit_id) as audit_id,us.name,'Document Process' AS module_name,(CASE WHEN fa.status_desc = 'Approved' THEN 'Uploaded' ELSE fa.status_desc END) AS ACTION,date_format(fa.process_date,'%d-%m-%Y & %h:%i:%s') AS action_date,fa.role_name FROM formprocessing_audit AS fa INNER JOIN users us ON (us.id=fa.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)WHERE date_format(fa.process_date,'%Y-%m-%d') LIKE '".$receipt_no1."%'  and us.email LIKE '".$user_id."%' and date_format(fa.process_date,'%Y-%m-%d') LIKE '".$receipt_no2."%' and fa.status_desc LIKE '".$form_action."%' ");

            }
            if($source_type =='Work Flow')
            {

              $rows=DB::select("
                SELECT concat('workflow','#',wa.id) as audit_id,us.name,'Workflow' AS module_name,wa.description AS ACTION,date_format(wa.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,wa.role_name  FROM operations_audit_logs AS wa 
                INNER JOIN users us ON (us.id=wa.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)WHERE date_format(wa.action_date_time,'%Y-%m-%d') LIKE '".$receipt_no1."%'  and date_format(wa.action_date_time,'%Y-%m-%d') LIKE '".$receipt_no2."%' and us.email LIKE '".$user_id."%' and wa.audit_action LIKE '".$workflow_action."%' 
                ");

            }
            if($source_type =='UAM'){


              $rows=DB::select("SELECT concat('UAM','#',al.id) as audit_id,us.name,'UAM' AS module_name,Al.description as ACTION,date_format(Al.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,Al.role_name  FROM audit_logs Al INNER JOIN users us on(us.id=al.user_id)
               INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)WHERE date_format(Al.action_date_time,'%Y-%m-%d') LIKE '".$receipt_no1."%'  and us.email LIKE '".$user_id."%' and date_format(Al.action_date_time,'%Y-%m-%d') LIKE '".$receipt_no2."%' and Al.audit_action LIKE '".$uam_action."%' ");

            }
            if($source_type =='Department'){


              $rows=DB::select("SELECT concat('department','#',da.audit_id) as audit_id,us.name,'Department' AS module_name,da.action AS ACTION,date_format(da.process_date,'%d-%m-%Y & %h:%i:%s') AS action_date,da.role_name FROM department_audit AS da INNER JOIN users us ON (us.id=da.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
                WHERE date_format(da.process_date,'%Y-%m-%d') LIKE '".$receipt_no1."%'  and us.email LIKE '".$user_id."%' and date_format(da.process_date,'%Y-%m-%d') LIKE '".$receipt_no2."%' and da.status_desc LIKE '".$department_action."%' ");

            }
          }

          $rows1 = DB::table('users as a')
          ->select('a.*',)

          ->get();

          $response = [
            'rows' => $rows,
            'rows1' => $rows1
          ]; 



  // echo json_encode($rows);exit;
        // return $rows;   

          $serviceResponse = array();
          $serviceResponse['Code'] = config('setting.status_code.success');
          $serviceResponse['Message'] = config('setting.status_message.success');
          $serviceResponse['Data'] = $response;
          $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
          $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
          return $sendServiceResponse;
        } catch(\Exception $exc){
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

      public function login_search(Request $request)
      {

        $logMethod = 'Method => ReportController => login_search';
        try {           
          $inputArray = $this->decryptData($request->requestData);

          $user_id = $inputArray['user_id'];

          $from_date = $inputArray['from_date'];            
          $to_date = $inputArray['to_date'];

          if ($inputArray['user_id']=='All')
          {
            $user_id='';
          }
          else
          {
            $user_id=$inputArray['user_id'];
          }

          Log::error('[Method => ClaimrespondentController => log_detail1 => Step2 => success Code:'.$user_id.']');




          if($from_date !=''){
            $from_date1=date('Y-m-d', strtotime($from_date)); 
          }
          else
          {
            $from_date1='';
          }
          if($to_date !=''){
            $to_date1=date('Y-m-d', strtotime($to_date)); 
          }
          else
          {
            $to_date1='';
          }
          
          if(($from_date !='') && ($to_date !=''))

          {
           $rows=DB::select("SELECT concat('login','#',fa.audit_id) as audit_id,us.name,us.email,date_format(fa.login_time,'%d-%m-%Y & %h:%i:%s') AS login_time,date_format(fa.logout_time,'%d-%m-%Y & %h:%i:%s') AS logout_time FROM login_audit AS fa INNER JOIN users us ON (us.id=fa.user_id)

            WHERE DATE_FORMAT(fa.login_time,'%Y-%m-%d') >='".$from_date1."' AND date_format(fa.login_time,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
            UNION ALL
            SELECT concat('mismatch','#',mas.audit_id) as audit_id,'_'as name,mas.email,date_format(mas.attempt_time,'%d-%m-%Y & %h:%i:%s') AS login_time,'Unsuccessful Attempt' AS logout_time FROM mismatch_attempt_audit AS mas 
            WHERE DATE_FORMAT(mas.attempt_time,'%Y-%m-%d') >='".$from_date1."' AND date_format(mas.attempt_time,'%Y-%m-%d')   <= '".$to_date1."' and mas.email LIKE '".$user_id."%'");
         }
         else
         {
          $rows=DB::select("SELECT concat('login','#',fa.audit_id) as audit_id,us.name,us.email,date_format(fa.login_time,'%d-%m-%Y & %h:%i:%s') AS login_time,date_format(fa.logout_time,'%d-%m-%Y & %h:%i:%s') AS logout_time FROM login_audit AS fa INNER JOIN users us ON (us.id=fa.user_id)

            WHERE DATE_FORMAT(fa.login_time,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(fa.login_time,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'
            UNION ALL
            SELECT concat('mismatch','#',mas.audit_id) as audit_id,'_'as name,mas.email,date_format(mas.attempt_time,'%d-%m-%Y & %h:%i:%s') AS login_time,'Unsuccessful Attempt' AS logout_time FROM mismatch_attempt_audit AS mas 
            WHERE DATE_FORMAT(mas.attempt_time,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(mas.attempt_time,'%Y-%m-%d')  LIKE '".$to_date1."%' and mas.email LIKE '".$user_id."%'");
        }
        
        $rows1 = DB::table('users as a')
        ->select('a.*',)

        ->get();

        $response = [
          'rows' => $rows,
          'rows1' => $rows1
        ]; 



  // echo json_encode($rows);exit;
        // return $rows;   

        $serviceResponse = array();
        $serviceResponse['Code'] = config('setting.status_code.success');
        $serviceResponse['Message'] = config('setting.status_message.success');
        $serviceResponse['Data'] = $response;
        $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
        $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
        return $sendServiceResponse;
      } catch(\Exception $exc){
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

    public function userrole_search(Request $request)
    {

      $logMethod = 'Method => ReportController => userrole_search';
      try {           
        $inputArray = $this->decryptData($request->requestData);

        $user_id = $inputArray['user_id'];

        $from_date = $inputArray['from_date'];            
        $to_date = $inputArray['to_date'];





        if($from_date !=''){
          $from_date1=date('Y-m-d', strtotime($from_date)); 
        }
        else
        {
          $from_date1='';
        }
        if($to_date !=''){
          $to_date1=date('Y-m-d', strtotime($to_date)); 
        }
        else
        {
          $to_date1='';
        }
        if(($user_id !='') && ($from_date !='') && ($to_date !=''))
        {
         $rows=DB::select("SELECT concat('userrole','#',usa.audit_id) as audit_id,us.name,date_format(usa.action_date,'%d-%m-%Y & %h:%i:%s') AS action_time,(SELECT uam.role_name FROM uam_roles AS uam WHERE uam.role_id=usa.current_role_id) AS current_role,(SELECT uam.role_name FROM uam_roles AS uam WHERE uam.role_id=usa.previous_role_id) AS previous_role,usa.audit_status,(SELECT name FROM users  WHERE id=usa.created_by) AS changed_by FROM userrole_audit AS usa INNER JOIN users us ON (us.id=usa.user_id)

          WHERE DATE_FORMAT(usa.action_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(usa.action_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'");
       }
       else if (($user_id !='') || (($from_date !='') xor ($to_date !='')))
       {
        $rows=DB::select("SELECT concat('userrole','#',usa.audit_id) as audit_id,us.name,date_format(usa.action_date,'%d-%m-%Y & %h:%i:%s') AS action_time,(SELECT uam.role_name FROM uam_roles AS uam WHERE uam.role_id=usa.current_role_id) AS current_role,(SELECT uam.role_name FROM uam_roles AS uam WHERE uam.role_id=usa.previous_role_id) AS previous_role,usa.audit_status,(SELECT name FROM users  WHERE id=usa.created_by) AS changed_by FROM userrole_audit AS usa INNER JOIN users us ON (us.id=usa.user_id)

          WHERE DATE_FORMAT(usa.action_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(usa.action_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'");
      }
      else if(($from_date !='') && ($to_date !=''))
      {
       $rows=DB::select("SELECT concat('userrole','#',usa.audit_id) as audit_id,us.name,date_format(usa.action_date,'%d-%m-%Y & %h:%i:%s') AS action_time,(SELECT uam.role_name FROM uam_roles AS uam WHERE uam.role_id=usa.current_role_id) AS current_role,(SELECT uam.role_name FROM uam_roles AS uam WHERE uam.role_id=usa.previous_role_id) AS previous_role,usa.audit_status,(SELECT name FROM users  WHERE id=usa.created_by) AS changed_by FROM userrole_audit AS usa INNER JOIN users us ON (us.id=usa.user_id)

        WHERE DATE_FORMAT(usa.action_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(usa.action_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'");
     }

     $rows1 = DB::table('users as a')
     ->select('a.*',)

     ->get();

     $response = [
      'rows' => $rows,
      'rows1' => $rows1
    ]; 



  // echo json_encode($rows);exit;
        // return $rows;   

    $serviceResponse = array();
    $serviceResponse['Code'] = config('setting.status_code.success');
    $serviceResponse['Message'] = config('setting.status_message.success');
    $serviceResponse['Data'] = $response;
    $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
    $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
    return $sendServiceResponse;
  } catch(\Exception $exc){
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

public function process_search(Request $request)
{

  $logMethod = 'Method => ReportController => process_search';
  try {           
    $inputArray = $this->decryptData($request->requestData);

    $user_id = $inputArray['user_id'];

    $from_date = $inputArray['from_date'];            
    $to_date = $inputArray['to_date'];

    $workflow_action = $inputArray['workflow_action'];

    $workflow_name=$inputArray['workflow_name'];

    $freeTextSearch=$inputArray['freeTextSearch'];

    if ($inputArray['workflow_action']=='All')
    {
      $workflow_action='';
    }
    else
    {
      $workflow_action=$inputArray['workflow_action'];
    }

    if ($inputArray['user_id']=='All')
    {
      $user_id='';
    }
    else
    {
      $user_id=$inputArray['user_id'];
    }








    if($from_date !=''){
      $from_date1=date('Y-m-d', strtotime($from_date)); 
    }
    else
    {
      $from_date1='';
    }
    if($to_date !=''){
      $to_date1=date('Y-m-d', strtotime($to_date)); 
    }
    else
    {
      $to_date1='';
    }
    if(($from_date !='') && ($to_date !=''))
    {
     $rows=DB::select("SELECT concat('workflow','#',wa.id) as audit_id,ta.tasks_type,ta.tasks_id,us.name,'Workflow' AS module_name,wa.description AS ACTION,date_format(wa.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,wa.role_name,ta.document_subject,wa.screen  FROM operations_audit_logs AS wa 
      INNER JOIN tasks ta ON(ta.tasks_id=wa.audit_table_id)
      INNER JOIN users us ON (us.id=wa.user_id)
      INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)

      WHERE wa.active_flag='1' and DATE_FORMAT(wa.action_date_time,'%Y-%m-%d') >='".$from_date1."' AND date_format(wa.action_date_time,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%' and wa.screen LIKE '".$workflow_name."%' and wa.audit_action LIKE '".$workflow_action."%' and ta.document_subject LIKE '".$freeTextSearch."%'");
   }
   
   else
   {
    $rows=DB::select("SELECT concat('workflow','#',wa.id) as audit_id,ta.tasks_type,ta.tasks_id,us.name,'Workflow' AS module_name,wa.description AS ACTION,date_format(wa.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,wa.role_name,ta.document_subject,wa.screen  FROM operations_audit_logs AS wa 
      INNER JOIN tasks ta ON(ta.tasks_id=wa.audit_table_id)
      INNER JOIN users us ON (us.id=wa.user_id)
      INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)

      WHERE wa.active_flag='1' and DATE_FORMAT(wa.action_date_time,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(wa.action_date_time,'%Y-%m-%d')  LIKE '".$to_date1."%' and wa.screen LIKE '".$workflow_name."%' and us.email LIKE '".$user_id."%' and wa.audit_action LIKE '".$workflow_action."%' and ta.document_subject LIKE '".$freeTextSearch."%'");
  }

  

  
  



  $rows1 = DB::table('users as a')
  ->select('a.*',)
  ->where('a.active_flag',0)
  ->get();

  $response = [
    'rows' => $rows,
    'rows1' => $rows1
  ]; 



  // echo json_encode($rows);exit;
        // return $rows;   

  $serviceResponse = array();
  $serviceResponse['Code'] = config('setting.status_code.success');
  $serviceResponse['Message'] = config('setting.status_message.success');
  $serviceResponse['Data'] = $response;
  $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
  $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
  return $sendServiceResponse;
} catch(\Exception $exc){
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

public function newdoc_search(Request $request)
{

  $logMethod = 'Method => ReportController => login_search';
  try {           
    $inputArray = $this->decryptData($request->requestData);

    $user_id = $inputArray['user_id'];

    $from_date = $inputArray['from_date'];            
    $to_date = $inputArray['to_date'];





    if($from_date !=''){
      $from_date1=date('Y-m-d', strtotime($from_date)); 
    }
    else
    {
      $from_date1='';
    }
    if($to_date !=''){
      $to_date1=date('Y-m-d', strtotime($to_date)); 
    }
    else
    {
      $to_date1='';
    }
    if(($user_id !='') && ($from_date !='') && ($to_date !=''))
    {
      $folder_rows=DB::select("SELECT dff.document_folder_structure_id  FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL 
        SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and  DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
        LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null and  DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'" );
      $rows=array();
      $rows_dep=array();

      foreach ($folder_rows as $folder_rows1) {

        $folder_id=$folder_rows1->document_folder_structure_id;

        Log::error('[Method => Dashboardcontroller => log_detail1 => Step2 => success Code:'.json_encode($folder_id).']');

        $parentFolders = DB::select('call get_parent_folders(?)', array($folder_id));
        $response = [
          'parentFolders' => $parentFolders[2],
        ];
        $response1 = [
          'parentFolders' => $parentFolders[3],
        ];
        $folder=$response['parentFolders']->document_folder_structure_id;
        $folder1=$response1['parentFolders']->document_folder_structure_id; 

        $rows_dep[]=DB::select("SELECT (SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder.") AS directorate,(SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder1.") AS department FROM document_folder_files dff INNER JOIN users us ON (us.id=dff.created_by) WHERE dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'" );

      }
      
      $rows=DB::select("SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'Form Processing' as document_type,dst.source_type as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.created_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name  FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_source_types dst ON(dst.document_source_type_id=dp.document_source_type_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'Work Flow' as document_type,'Work Flow' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.created_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'File' as document_type,'File' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.created_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
        LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null
        and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%' ");

    }

    else if (($user_id !='') || (($from_date !='') xor ($to_date !='')))
    {
      $folder_rows=DB::select("SELECT dff.document_folder_structure_id  FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.created_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'
        UNION ALL 
        SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.created_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
        LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null and  DATE_FORMAT(dff.created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.created_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'" );
      $rows=array();
      $rows_dep=array();

      foreach ($folder_rows as $folder_rows1) {

        $folder_id=$folder_rows1->document_folder_structure_id;

        Log::error('[Method => Dashboardcontroller => log_detail1 => Step2 => success Code:'.json_encode($folder_id).']');

        $parentFolders = DB::select('call get_parent_folders(?)', array($folder_id));
        $response = [
          'parentFolders' => $parentFolders[2],
        ];
        $response1 = [
          'parentFolders' => $parentFolders[3],
        ];
        $folder=$response['parentFolders']->document_folder_structure_id;
        $folder1=$response1['parentFolders']->document_folder_structure_id; 

        $rows_dep[]=DB::select("SELECT (SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder.") AS directorate,(SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder1.") AS department FROM document_folder_files dff INNER JOIN users us ON (us.id=dff.created_by) WHERE dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.created_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'" );

      }
      
      $rows=DB::select("SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'Form Processing' as document_type,dst.source_type as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.created_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name  FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_source_types dst ON(dst.document_source_type_id=dp.document_source_type_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.created_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'Work Flow' as document_type,'Work Flow' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.created_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.created_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'File' as document_type,'File' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.created_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
        LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null
        and DATE_FORMAT(dff.created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.created_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%' ");

    }

    else if(($from_date !='') && ($to_date !=''))
    {
      $folder_rows=DB::select("SELECT dff.document_folder_structure_id  FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL 
        SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
        LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'" );
      $rows=array();
      $rows_dep=array();

      foreach ($folder_rows as $folder_rows1) {

        $folder_id=$folder_rows1->document_folder_structure_id;

        

        $parentFolders = DB::select('call get_parent_folders(?)', array($folder_id));
        $response = [
          'parentFolders' => $parentFolders[2],
        ];
        $response1 = [
          'parentFolders' => $parentFolders[3],
        ];
        $folder=$response['parentFolders']->document_folder_structure_id;
        $folder1=$response1['parentFolders']->document_folder_structure_id; 

        $rows_dep[]=DB::select("SELECT (SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder.") AS directorate,(SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder1.") AS department FROM document_folder_files dff INNER JOIN users us ON (us.id=dff.created_by)  WHERE dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'" );

      }
      
      $rows=DB::select("SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'Form Processing' as document_type,dst.source_type as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.created_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name  FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_source_types dst ON(dst.document_source_type_id=dp.document_source_type_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'Work Flow' as document_type,'Work Flow' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.created_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'File' as document_type,'File' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.created_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
        LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null
        and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'");

    }


    $rows1 = DB::table('users as a')
    ->select('a.*',)
    ->where('a.active_flag',0)
    ->get();

    $response = [
      'rows' => $rows,
      'rows1' => $rows1,
      'rows_dep' => $rows_dep
    ]; 




  // echo json_encode($rows);exit;
        // return $rows;   

    $serviceResponse = array();
    $serviceResponse['Code'] = config('setting.status_code.success');
    $serviceResponse['Message'] = config('setting.status_message.success');
    $serviceResponse['Data'] = $response;
    $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
    $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
    return $sendServiceResponse;
  } catch(\Exception $exc){
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

public function deletedoc_search(Request $request)
{

  $logMethod = 'Method => ReportController => deletedoc_search';
  try {           
    $inputArray = $this->decryptData($request->requestData);

    $user_id = $inputArray['user_id'];

    $from_date = $inputArray['from_date'];            
    $to_date = $inputArray['to_date'];





    if($from_date !=''){
      $from_date1=date('Y-m-d', strtotime($from_date)); 
    }
    else
    {
      $from_date1='';
    }
    if($to_date !=''){
      $to_date1=date('Y-m-d', strtotime($to_date)); 
    }
    else
    {
      $to_date1='';
    }
    if(($user_id !='') && ($from_date !='') && ($to_date !=''))
    {
      $folder_rows=DB::select("SELECT dff.document_folder_structure_id  FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '0' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL 
        SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '0' and  DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
        LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '0' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null and  DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'" );
      $rows=array();
      $rows_dep=array();

      foreach ($folder_rows as $folder_rows1) {

        $folder_id=$folder_rows1->document_folder_structure_id;

        Log::error('[Method => Dashboardcontroller => log_detail1 => Step2 => success Code:'.json_encode($folder_id).']');

        $parentFolders = DB::select('call get_parent_folders(?)', array($folder_id));
        $response = [
          'parentFolders' => $parentFolders[2],
        ];
        $response1 = [
          'parentFolders' => $parentFolders[3],
        ];
        $folder=$response['parentFolders']->document_folder_structure_id;
        $folder1=$response1['parentFolders']->document_folder_structure_id; 

        $rows_dep[]=DB::select("SELECT (SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder.") AS directorate,(SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder1.") AS department FROM document_folder_files dff INNER JOIN users us ON (us.id=dff.created_by) WHERE dff.active_flag = '0' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'" );

      }
      
      $rows=DB::select("SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'Form Processing' as document_type,dst.source_type as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.last_modified_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name  FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_source_types dst ON(dst.document_source_type_id=dp.document_source_type_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '0' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'Work Flow' as document_type,'Work Flow' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.last_modified_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '0' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'File' as document_type,'File' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.last_modified_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
        LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '0' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null
        and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%' ");

    }

    else if (($user_id !='') || (($from_date !='') xor ($to_date !='')))
    {
      $folder_rows=DB::select("SELECT dff.document_folder_structure_id  FROM document_folder_files AS dff

        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '0' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.last_modified_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'
        UNION ALL 
        SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '0' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.last_modified_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
        LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '0' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null and  DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.last_modified_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'" );
      $rows=array();
      $rows_dep=array();

      foreach ($folder_rows as $folder_rows1) {

        $folder_id=$folder_rows1->document_folder_structure_id;

        Log::error('[Method => Dashboardcontroller => log_detail1 => Step2 => success Code:'.json_encode($folder_id).']');

        $parentFolders = DB::select('call get_parent_folders(?)', array($folder_id));
        $response = [
          'parentFolders' => $parentFolders[2],
        ];
        $response1 = [
          'parentFolders' => $parentFolders[3],
        ];
        $folder=$response['parentFolders']->document_folder_structure_id;
        $folder1=$response1['parentFolders']->document_folder_structure_id; 

        $rows_dep[]=DB::select("SELECT (SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder.") AS directorate,(SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder1.") AS department FROM document_folder_files dff INNER JOIN users us ON (us.id=dff.created_by) WHERE dff.active_flag = '0' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.last_modified_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'" );

      }
      
      $rows=DB::select("SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'Form Processing' as document_type,dst.source_type as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.last_modified_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name  FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_source_types dst ON(dst.document_source_type_id=dp.document_source_type_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '0' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.last_modified_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'Work Flow' as document_type,'Work Flow' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.last_modified_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '0' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.last_modified_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'File' as document_type,'File' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.last_modified_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
        LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '0' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null
        and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.last_modified_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%' ");

    }

    else if(($from_date !='') && ($to_date !=''))
    {
      $folder_rows=DB::select("SELECT dff.document_folder_structure_id  FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '0' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL 
        SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '0' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
        LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '0' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'" );
      $rows=array();
      $rows_dep=array();

      foreach ($folder_rows as $folder_rows1) {

        $folder_id=$folder_rows1->document_folder_structure_id;

        

        $parentFolders = DB::select('call get_parent_folders(?)', array($folder_id));
        $response = [
          'parentFolders' => $parentFolders[2],
        ];
        $response1 = [
          'parentFolders' => $parentFolders[3],
        ];
        $folder=$response['parentFolders']->document_folder_structure_id;
        $folder1=$response1['parentFolders']->document_folder_structure_id; 

        $rows_dep[]=DB::select("SELECT (SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder.") AS directorate,(SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder1.") AS department FROM document_folder_files dff INNER JOIN users us ON (us.id=dff.created_by)  WHERE dff.active_flag = '0' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'" );

      }
      
      $rows=DB::select("SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'Form Processing' as document_type,dst.source_type as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.last_modified_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name  FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_source_types dst ON(dst.document_source_type_id=dp.document_source_type_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '0' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'Work Flow' as document_type,'Work Flow' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.last_modified_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '0' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'File' as document_type,'File' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.last_modified_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
        LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '0' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null
        and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'");

    }


    $rows1 = DB::table('users as a')
    ->select('a.*',)
    ->where('a.active_flag',0)
    ->get();

    $response = [
      'rows' => $rows,
      'rows1' => $rows1,
      'rows_dep' => $rows_dep
    ]; 




  // echo json_encode($rows);exit;
        // return $rows;   

    $serviceResponse = array();
    $serviceResponse['Code'] = config('setting.status_code.success');
    $serviceResponse['Message'] = config('setting.status_message.success');
    $serviceResponse['Data'] = $response;
    $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
    $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
    return $sendServiceResponse;
  } catch(\Exception $exc){
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

public function archivedoc_search(Request $request)
{

  $logMethod = 'Method => ReportController => archivedoc_search';
  try {           
    $inputArray = $this->decryptData($request->requestData);

    $user_id = $inputArray['user_id'];

    $from_date = $inputArray['from_date'];            
    $to_date = $inputArray['to_date'];





    if($from_date !=''){
      $from_date1=date('Y-m-d', strtotime($from_date)); 
    }
    else
    {
      $from_date1='';
    }
    if($to_date !=''){
      $to_date1=date('Y-m-d', strtotime($to_date)); 
    }
    else
    {
      $to_date1='';
    }
    if(($user_id !='') && ($from_date !='') && ($to_date !=''))
    {
      $folder_rows=DB::select("SELECT dff.document_folder_structure_id  FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '2' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL 
        SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '2' and  DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
        LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '2' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null and  DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'" );
      $rows=array();
      $rows_dep=array();

      foreach ($folder_rows as $folder_rows1) {

        $folder_id=$folder_rows1->document_folder_structure_id;

        Log::error('[Method => Dashboardcontroller => log_detail1 => Step2 => success Code:'.json_encode($folder_id).']');

        $parentFolders = DB::select('call get_parent_folders(?)', array($folder_id));
        $response = [
          'parentFolders' => $parentFolders[2],
        ];
        $response1 = [
          'parentFolders' => $parentFolders[3],
        ];
        $folder=$response['parentFolders']->document_folder_structure_id;
        $folder1=$response1['parentFolders']->document_folder_structure_id; 

        $rows_dep[]=DB::select("SELECT (SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder.") AS directorate,(SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder1.") AS department FROM document_folder_files dff INNER JOIN users us ON (us.id=dff.created_by) WHERE dff.active_flag = '2' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'" );

      }
      
      $rows=DB::select("SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'Form Processing' as document_type,dst.source_type as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.last_modified_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name  FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_source_types dst ON(dst.document_source_type_id=dp.document_source_type_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '2' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'Work Flow' as document_type,'Work Flow' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.last_modified_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '2' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'File' as document_type,'File' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.last_modified_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
        LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '2' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null
        and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%' ");

    }

    else if (($user_id !='') || (($from_date !='') xor ($to_date !='')))
    {
      $folder_rows=DB::select("SELECT dff.document_folder_structure_id  FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '2' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.last_modified_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'
        UNION ALL 
        SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '2' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.last_modified_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
        LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '2' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null and  DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.last_modified_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'" );
      $rows=array();
      $rows_dep=array();

      foreach ($folder_rows as $folder_rows1) {

        $folder_id=$folder_rows1->document_folder_structure_id;

        Log::error('[Method => Dashboardcontroller => log_detail1 => Step2 => success Code:'.json_encode($folder_id).']');

        $parentFolders = DB::select('call get_parent_folders(?)', array($folder_id));
        $response = [
          'parentFolders' => $parentFolders[2],
        ];
        $response1 = [
          'parentFolders' => $parentFolders[3],
        ];
        $folder=$response['parentFolders']->document_folder_structure_id;
        $folder1=$response1['parentFolders']->document_folder_structure_id; 

        $rows_dep[]=DB::select("SELECT (SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder.") AS directorate,(SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder1.") AS department FROM document_folder_files dff INNER JOIN users us ON (us.id=dff.created_by) WHERE dff.active_flag = '2' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.last_modified_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'" );

      }
      
      $rows=DB::select("SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'Form Processing' as document_type,dst.source_type as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.last_modified_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name  FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_source_types dst ON(dst.document_source_type_id=dp.document_source_type_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '2' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.last_modified_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'Work Flow' as document_type,'Work Flow' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.last_modified_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '2' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.last_modified_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'File' as document_type,'File' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.last_modified_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
        LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '2' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null
        and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.last_modified_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%' ");

    }

    else if(($from_date !='') && ($to_date !=''))
    {
      $folder_rows=DB::select("SELECT dff.document_folder_structure_id  FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '2' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL 
        SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '2' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
        LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '2' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'" );
      $rows=array();
      $rows_dep=array();

      foreach ($folder_rows as $folder_rows1) {

        $folder_id=$folder_rows1->document_folder_structure_id;

        

        $parentFolders = DB::select('call get_parent_folders(?)', array($folder_id));
        $response = [
          'parentFolders' => $parentFolders[2],
        ];
        $response1 = [
          'parentFolders' => $parentFolders[3],
        ];
        $folder=$response['parentFolders']->document_folder_structure_id;
        $folder1=$response1['parentFolders']->document_folder_structure_id; 

        $rows_dep[]=DB::select("SELECT (SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder.") AS directorate,(SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder1.") AS department FROM document_folder_files dff INNER JOIN users us ON (us.id=dff.created_by)  WHERE dff.active_flag = '2' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'" );

      }
      
      $rows=DB::select("SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'Form Processing' as document_type,dst.source_type as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.last_modified_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name  FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_source_types dst ON(dst.document_source_type_id=dp.document_source_type_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '2' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'Work Flow' as document_type,'Work Flow' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.last_modified_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '2' and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id, 'File' as document_type,'File' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.last_modified_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
        LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '2' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null
        and DATE_FORMAT(dff.last_modified_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.last_modified_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'");

    }


    $rows1 = DB::table('users as a')
    ->select('a.*',)
    ->where('a.active_flag',0)
    ->get();

    $response = [
      'rows' => $rows,
      'rows1' => $rows1,
      'rows_dep' => $rows_dep
    ]; 




  // echo json_encode($rows);exit;
        // return $rows;   

    $serviceResponse = array();
    $serviceResponse['Code'] = config('setting.status_code.success');
    $serviceResponse['Message'] = config('setting.status_message.success');
    $serviceResponse['Data'] = $response;
    $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
    $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
    return $sendServiceResponse;
  } catch(\Exception $exc){
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

public function processdoc_search(Request $request)
{

  $logMethod = 'Method => ReportController => processdoc_search';
  try {           
    $inputArray = $this->decryptData($request->requestData);

    $user_id = $inputArray['user_id'];

    $from_date = $inputArray['from_date'];            
    $to_date = $inputArray['to_date'];
    $source_type = $inputArray['source_type'];

    if($from_date !=''){
      $from_date1=date('Y-m-d', strtotime($from_date)); 
    }
    else
    {
      $from_date1='';
    }
    if($to_date !=''){
      $to_date1=date('Y-m-d', strtotime($to_date)); 
    }
    else
    {
      $to_date1='';
    }
    
    if (((($user_id !='') && ($source_type =='')) && (($from_date !='') && ($to_date !=''))) && ($source_type =='')) 
    {
      $folder_rows=DB::select("SELECT dff.document_folder_structure_id  FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL 
        SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and  DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
        LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null and  DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'" );
      $rows=array();
      $rows_dep=array();

      foreach ($folder_rows as $folder_rows1) {

        $folder_id=$folder_rows1->document_folder_structure_id;

        Log::error('[Method => Dashboardcontroller => log_detail1 => Step2 => success Code:'.json_encode($folder_id).']');

        $parentFolders = DB::select('call get_parent_folders(?)', array($folder_id));
        $response = [
          'parentFolders' => $parentFolders[2],
        ];
        $response1 = [
          'parentFolders' => $parentFolders[3],
        ];
        $folder=$response['parentFolders']->document_folder_structure_id;
        $folder1=$response1['parentFolders']->document_folder_structure_id; 

        $rows_dep[]=DB::select("SELECT (SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder.") AS directorate,(SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder1.") AS department FROM document_folder_files dff INNER JOIN users us ON (us.id=dff.created_by) WHERE dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'" );

      }
      
      $rows=DB::select("SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id,dff.document_extension, 'Form Processing' as document_type,dst.source_type as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.created_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name  FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_source_types dst ON(dst.document_source_type_id=dp.document_source_type_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id,dff.document_extension, 'Work Flow' as document_type,'Work Flow' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.created_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id,dff.document_extension, 'File' as document_type,'File' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.created_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
        LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null
        and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%' ");

    }

    else if (((($user_id !='') && ($source_type =='')) || (($from_date !='') xor ($to_date !=''))) && ($source_type =='')) {
      $folder_rows=DB::select("SELECT dff.document_folder_structure_id  FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.created_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'
        UNION ALL 
        SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.created_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
        LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null and  DATE_FORMAT(dff.created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.created_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'" );
      $rows=array();
      $rows_dep=array();

      foreach ($folder_rows as $folder_rows1) {

        $folder_id=$folder_rows1->document_folder_structure_id;

        Log::error('[Method => Dashboardcontroller => log_detail1 => Step2 => success Code:'.json_encode($folder_id).']');

        $parentFolders = DB::select('call get_parent_folders(?)', array($folder_id));
        $response = [
          'parentFolders' => $parentFolders[2],
        ];
        $response1 = [
          'parentFolders' => $parentFolders[3],
        ];
        $folder=$response['parentFolders']->document_folder_structure_id;
        $folder1=$response1['parentFolders']->document_folder_structure_id; 

        $rows_dep[]=DB::select("SELECT (SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder.") AS directorate,(SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder1.") AS department FROM document_folder_files dff INNER JOIN users us ON (us.id=dff.created_by) WHERE dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.created_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'" );

      }
      
      $rows=DB::select("SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id,dff.document_extension, 'Form Processing' as document_type,dst.source_type as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.created_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name  FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_source_types dst ON(dst.document_source_type_id=dp.document_source_type_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.created_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id,dff.document_extension, 'Work Flow' as document_type,'Work Flow' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.created_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.created_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'
        UNION ALL
        SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id,dff.document_extension, 'File' as document_type,'File' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.created_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
        LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null
        and DATE_FORMAT(dff.created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.created_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%' ");

    }

    else if(($source_type !='') && ($from_date !='') && ($to_date !=''))
    {
     if($source_type !='Work Flow'){

      $folder_rows=DB::select("SELECT dff.document_folder_structure_id  FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and dff.document_source_type_id like '".$source_type."' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'" );
      $rows=array();
      $rows_dep=array();

      foreach ($folder_rows as $folder_rows1) {

        $folder_id=$folder_rows1->document_folder_structure_id;



        $parentFolders = DB::select('call get_parent_folders(?)', array($folder_id));
        $response = [
          'parentFolders' => $parentFolders[2],
        ];
        $response1 = [
          'parentFolders' => $parentFolders[3],
        ];
        $folder=$response['parentFolders']->document_folder_structure_id;
        $folder1=$response1['parentFolders']->document_folder_structure_id; 

        $rows_dep[]=DB::select("SELECT (SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder.") AS directorate,(SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder1.") AS department FROM document_folder_files dff INNER JOIN users us ON (us.id=dff.created_by)  WHERE dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'" );

      }

      $rows=DB::select("SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id,dff.document_extension,dff.document_source_type_id, 'Form Processing' as document_type,dst.source_type as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.created_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name  FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN document_source_types dst ON(dst.document_source_type_id=dff.document_source_type_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and dff.document_source_type_id like '".$source_type."' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'");
    }
    if($source_type =='Work Flow'){
      $folder_rows=DB::select("SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'" );
      $rows=array();
      $rows_dep=array();

      foreach ($folder_rows as $folder_rows1) {

        $folder_id=$folder_rows1->document_folder_structure_id;



        $parentFolders = DB::select('call get_parent_folders(?)', array($folder_id));
        $response = [
          'parentFolders' => $parentFolders[2],
        ];
        $response1 = [
          'parentFolders' => $parentFolders[3],
        ];
        $folder=$response['parentFolders']->document_folder_structure_id;
        $folder1=$response1['parentFolders']->document_folder_structure_id; 

        $rows_dep[]=DB::select("SELECT (SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder.") AS directorate,(SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder1.") AS department FROM document_folder_files dff INNER JOIN users us ON (us.id=dff.created_by)  WHERE dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'" );

      }

      $rows=DB::select("SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id,dff.document_extension, 'Work Flow' as document_type,'Work Flow' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.created_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
        INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
        INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
        INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
        INNER JOIN users us ON (us.id=dff.created_by)
        WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
        ");
    }
    
  }

  else if ((($source_type =='') && (($from_date !='') && ($to_date !=''))) && ($source_type =='')) 
  {
    $folder_rows=DB::select("SELECT dff.document_folder_structure_id  FROM document_folder_files AS dff
      INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
      INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
      INNER JOIN users us ON (us.id=dff.created_by)
      WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
      UNION ALL 
      SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
      INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
      INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
      INNER JOIN users us ON (us.id=dff.created_by)
      WHERE dfs.active_flag='1' and dff.active_flag = '1' and  DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
      UNION ALL
      SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
      INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
      LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
      LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
      INNER JOIN users us ON (us.id=dff.created_by)
      WHERE dfs.active_flag='1' and dff.active_flag = '1' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null and  DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'" );
    $rows=array();
    $rows_dep=array();

    foreach ($folder_rows as $folder_rows1) {

      $folder_id=$folder_rows1->document_folder_structure_id;

      Log::error('[Method => Dashboardcontroller => log_detail1 => Step2 => success Code:'.json_encode($folder_id).']');

      $parentFolders = DB::select('call get_parent_folders(?)', array($folder_id));
      $response = [
        'parentFolders' => $parentFolders[2],
      ];
      $response1 = [
        'parentFolders' => $parentFolders[3],
      ];
      $folder=$response['parentFolders']->document_folder_structure_id;
      $folder1=$response1['parentFolders']->document_folder_structure_id; 

      $rows_dep[]=DB::select("SELECT (SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder.") AS directorate,(SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder1.") AS department FROM document_folder_files dff INNER JOIN users us ON (us.id=dff.created_by) WHERE dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'" );

    }

    $rows=DB::select("SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id,dff.document_extension, 'Form Processing' as document_type,dst.source_type as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.created_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name  FROM document_folder_files AS dff
      INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
      INNER JOIN document_processes dp ON (dp.document_folder_file_id=dff.document_folder_file_id)
      INNER JOIN document_source_types dst ON(dst.document_source_type_id=dp.document_source_type_id)
      INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
      INNER JOIN users us ON (us.id=dff.created_by)
      WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
      UNION ALL
      SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id,dff.document_extension, 'Work Flow' as document_type,'Work Flow' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.created_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
      INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
      INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
      INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
      INNER JOIN users us ON (us.id=dff.created_by)
      WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%'
      UNION ALL
      SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id,dff.document_extension, 'File' as document_type,'File' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.created_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
      INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
      LEFT  JOIN document_processes dp ON (dp.document_folder_file_id =dff.document_folder_file_id )
      LEFT  JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
      INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
      INNER JOIN users us ON (us.id=dff.created_by)
      WHERE dfs.active_flag='1' and dff.active_flag = '1' and dp.document_folder_file_id IS null AND ta.document_folder_file_id IS null
      and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."' and us.email LIKE '".$user_id."%' ");

  }

  else if(($source_type !=''))
  {
   if($source_type !='Work Flow'){

    $folder_rows=DB::select("SELECT dff.document_folder_structure_id  FROM document_folder_files AS dff
      INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
      INNER JOIN users us ON (us.id=dff.created_by)
      WHERE dfs.active_flag='1' and dff.active_flag = '1' and dff.document_source_type_id like '".$source_type."' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.created_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'" );
    $rows=array();
    $rows_dep=array();

    foreach ($folder_rows as $folder_rows1) {

      $folder_id=$folder_rows1->document_folder_structure_id;



      $parentFolders = DB::select('call get_parent_folders(?)', array($folder_id));
      $response = [
        'parentFolders' => $parentFolders[2],
      ];
      $response1 = [
        'parentFolders' => $parentFolders[3],
      ];
      $folder=$response['parentFolders']->document_folder_structure_id;
      $folder1=$response1['parentFolders']->document_folder_structure_id; 

      $rows_dep[]=DB::select("SELECT (SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder.") AS directorate,(SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder1.") AS department FROM document_folder_files dff INNER JOIN users us ON (us.id=dff.created_by) WHERE dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.created_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'" );

    }

    $rows=DB::select("SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id,dff.document_extension,dff.document_source_type_id, 'Form Processing' as document_type,dst.source_type as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.created_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name  FROM document_folder_files AS dff
      INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
      INNER JOIN document_source_types dst ON(dst.document_source_type_id=dff.document_source_type_id)
      INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
      INNER JOIN users us ON (us.id=dff.created_by)
      WHERE dfs.active_flag='1' and dff.active_flag = '1' and dff.document_source_type_id like '".$source_type."' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.created_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'");
  }
  if($source_type =='Work Flow'){
    $folder_rows=DB::select("SELECT dff.document_folder_structure_id FROM document_folder_files AS dff
      INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
      INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
      INNER JOIN users us ON (us.id=dff.created_by)
      WHERE dfs.active_flag='1' and dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.created_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'" );
    $rows=array();
    $rows_dep=array();

    foreach ($folder_rows as $folder_rows1) {

      $folder_id=$folder_rows1->document_folder_structure_id;



      $parentFolders = DB::select('call get_parent_folders(?)', array($folder_id));
      $response = [
        'parentFolders' => $parentFolders[2],
      ];
      $response1 = [
        'parentFolders' => $parentFolders[3],
      ];
      $folder=$response['parentFolders']->document_folder_structure_id;
      $folder1=$response1['parentFolders']->document_folder_structure_id; 

      $rows_dep[]=DB::select("SELECT (SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder.") AS directorate,(SELECT folder_name FROM document_folder_structures WHERE document_folder_structure_id=".$folder1.") AS department FROM document_folder_files dff INNER JOIN users us ON (us.id=dff.created_by) WHERE dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.created_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'" );

    }

    $rows=DB::select("SELECT concat('document','#',dff.document_folder_file_id) as audit_id,dff.document_folder_structure_id,dff.document_extension, 'Work Flow' as document_type,'Work Flow' as source_type,dff.document_name,dt.category,dff.document_extension,date_format(dff.created_date,'%d-%m-%Y & %h:%i:%s') AS action_date,us.name FROM document_folder_files AS dff
      INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
      INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
      INNER JOIN document_categories dt ON (dt.document_category_id=dff.document_category_id)
      INNER JOIN users us ON (us.id=dff.created_by)
      WHERE dfs.active_flag='1' and  dff.active_flag = '1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.created_date,'%Y-%m-%d')  LIKE '".$to_date1."%' and us.email LIKE '".$user_id."%'
      ");
  }
  
}


$rows1 = DB::table('users as a')
->select('a.*',)
->where('a.active_flag',0)
->get();

$response = [
  'rows' => $rows,
  'rows1' => $rows1,
  'rows_dep' => $rows_dep
]; 




  // echo json_encode($rows);exit;
        // return $rows;   

$serviceResponse = array();
$serviceResponse['Code'] = config('setting.status_code.success');
$serviceResponse['Message'] = config('setting.status_message.success');
$serviceResponse['Data'] = $response;
$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
return $sendServiceResponse;
} 
catch(\Exception $exc){
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

public function grouped_search(Request $request)
{

  $logMethod = 'Method => ReportController => grouped_search';
  try {           
    $inputArray = $this->decryptData($request->requestData);

    // $user_id = $inputArray['user_id'];

    $from_date = $inputArray['from_date'];            
    $to_date = $inputArray['to_date'];

    





    if($from_date !=''){
      $from_date1=date('Y-m-d', strtotime($from_date)); 
    }
    else
    {
      $from_date1='';
    }
    if($to_date !=''){
      $to_date1=date('Y-m-d', strtotime($to_date)); 
    }
    else
    {
      $to_date1='';
    }
    if(($from_date !='') && ($to_date !=''))
    {


     $rows=DB::select("SELECT DISTINCT dff.document_source_type_id , dst.source_type ,(SELECT folder_name FROM document_folder_structures dfs where dfs.document_folder_structure_id=dff.department_id) AS department,(SELECT folder_name FROM document_folder_structures dfs where dfs.document_folder_structure_id=dff.directorate_id) AS directorate,dt.category,dff.document_extension,dt.document_category_id,dff.directorate_id,dff.department_id  FROM document_folder_files dff 
      INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
      JOIN document_source_types dst ON(dst.document_source_type_id=dff.document_source_type_id)
      
      INNER JOIN document_categories dt ON(dt.document_category_id=dff.document_category_id)
      WHERE dfs.active_flag='1' and dff.active_flag='1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."'
      UNION ALL
      SELECT DISTINCT dff.document_source_type_id ,'Workflow' AS source_type,  (SELECT folder_name FROM document_folder_structures dfs where dfs.document_folder_structure_id=dff.department_id) AS department,(SELECT folder_name FROM document_folder_structures dfs where dfs.document_folder_structure_id=dff.directorate_id) AS directorate,dt.category,dff.document_extension,dt.document_category_id,dff.directorate_id,dff.department_id FROM document_folder_files dff
      INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id)
      INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
      INNER JOIN document_categories dt ON(dt.document_category_id=dff.document_category_id) 
      WHERE dfs.active_flag='1' and  dff.active_flag='1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(dff.created_date,'%Y-%m-%d')   <= '".$to_date1."'");

     foreach ($rows as $rows1) {

      $directorateid=$rows1->directorate_id;

      $departmentid=$rows1->department_id;

      $documenttypeid=$rows1->document_category_id;

      $document_source_type_id=$rows1->document_source_type_id;

      if ($document_source_type_id=='')

      {
        $rows_added[]=DB::select("SELECT distinct COUNT(*) AS count FROM document_folder_files WHERE document_source_type_id is null and directorate_id='".$directorateid."' AND department_id='".$departmentid."' AND document_category_id='".$documenttypeid."' and active_flag='1' and DATE_FORMAT(created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(created_date,'%Y-%m-%d')   <= '".$to_date1."'" );
        $rows_delete[]=DB::select("SELECT distinct COUNT(*) AS count FROM document_folder_files WHERE document_source_type_id is null and directorate_id='".$directorateid."' AND department_id='".$departmentid."' AND document_category_id='".$documenttypeid."' and active_flag='0' and DATE_FORMAT(created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(created_date,'%Y-%m-%d')   <= '".$to_date1."'" );
        $rows_archive[]=DB::select("SELECT distinct COUNT(*) AS count FROM document_folder_files WHERE document_source_type_id is null and directorate_id='".$directorateid."' AND department_id='".$departmentid."' AND document_category_id='".$documenttypeid."' and  active_flag='2' and DATE_FORMAT(created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(created_date,'%Y-%m-%d')   <= '".$to_date1."'" );

      }
      else
      {
        $rows_added[]=DB::select("SELECT distinct COUNT(*) AS count FROM document_folder_files WHERE document_source_type_id like '".$document_source_type_id."'and directorate_id='".$directorateid."' AND department_id='".$departmentid."' AND document_category_id='".$documenttypeid."' and active_flag='1' and DATE_FORMAT(created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(created_date,'%Y-%m-%d')   <= '".$to_date1."'" );
        $rows_delete[]=DB::select("SELECT distinct COUNT(*) AS count FROM document_folder_files WHERE document_source_type_id like '".$document_source_type_id."'and directorate_id='".$directorateid."' AND department_id='".$departmentid."' AND document_category_id='".$documenttypeid."' and active_flag='0' and DATE_FORMAT(created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(created_date,'%Y-%m-%d')   <= '".$to_date1."'" );
        $rows_archive[]=DB::select("SELECT distinct COUNT(*) AS count FROM document_folder_files WHERE document_source_type_id like '".$document_source_type_id."'and directorate_id='".$directorateid."' AND department_id='".$departmentid."' AND document_category_id='".$documenttypeid."' and  active_flag='2' and DATE_FORMAT(created_date,'%Y-%m-%d') >='".$from_date1."' AND date_format(created_date,'%Y-%m-%d')   <= '".$to_date1."'" );

      }




      

    }


  }

  else
  {
    $rows=DB::select("SELECT DISTINCT dff.document_source_type_id ,dst.source_type  ,(SELECT folder_name FROM document_folder_structures dfs where dfs.document_folder_structure_id=dff.department_id) AS department,(SELECT folder_name FROM document_folder_structures dfs where dfs.document_folder_structure_id=dff.directorate_id) AS directorate,dt.category,dff.document_extension,dt.document_category_id,dff.directorate_id,dff.department_id  FROM document_folder_files dff 
      INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id) 
      
      JOIN document_source_types dst ON(dst.document_source_type_id=dff.document_source_type_id) 
      INNER JOIN document_categories dt ON(dt.document_category_id=dff.document_category_id)
      WHERE dfs.active_flag='1' and  dff.active_flag='1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.created_date,'%Y-%m-%d')  LIKE '".$to_date1."%'
      UNION ALL
      SELECT DISTINCT dff.document_source_type_id ,'Workflow' AS source_type,  (SELECT folder_name FROM document_folder_structures dfs where dfs.document_folder_structure_id=dff.department_id) AS department,(SELECT folder_name FROM document_folder_structures dfs where dfs.document_folder_structure_id=dff.directorate_id) AS directorate,dt.category,dff.document_extension,dt.document_category_id,dff.directorate_id,dff.department_id FROM document_folder_files dff
      INNER JOIN document_folder_structures dfs ON (dfs.document_folder_structure_id=dff.document_folder_structure_id) 
      INNER JOIN tasks_attachments ta ON (ta.document_folder_file_id=dff.document_folder_file_id)
      INNER JOIN document_categories dt ON(dt.document_category_id=dff.document_category_id) 
      WHERE dfs.active_flag='1' and  dff.active_flag='1' and DATE_FORMAT(dff.created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(dff.created_date,'%Y-%m-%d')  LIKE '".$to_date1."%'");

    $rows_archive=array();
    $rows_added=array();
    $rows_delete=array();

    foreach ($rows as $rows1) {

      $directorateid=$rows1->directorate_id;

      $departmentid=$rows1->department_id;

      $documenttypeid=$rows1->document_category_id;

      $document_source_type_id=$rows1->document_source_type_id;

      

      if ($document_source_type_id=='')

      {
        $rows_added[]=DB::select("SELECT distinct COUNT(*) AS count FROM document_folder_files WHERE document_source_type_id is null and directorate_id='".$directorateid."' AND department_id='".$departmentid."' AND document_category_id='".$documenttypeid."' and active_flag='1' and DATE_FORMAT(created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(created_date,'%Y-%m-%d')  LIKE '".$to_date1."%'" );
        $rows_delete[]=DB::select("SELECT distinct COUNT(*) AS count FROM document_folder_files WHERE document_source_type_id is null and directorate_id='".$directorateid."' AND department_id='".$departmentid."' AND document_category_id='".$documenttypeid."' and active_flag='0' and DATE_FORMAT(created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(created_date,'%Y-%m-%d')  LIKE '".$to_date1."%'" );
        $rows_archive[]=DB::select("SELECT distinct COUNT(*) AS count FROM document_folder_files WHERE document_source_type_id is null and directorate_id='".$directorateid."' AND department_id='".$departmentid."' AND document_category_id='".$documenttypeid."' and  active_flag='2' and DATE_FORMAT(created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(created_date,'%Y-%m-%d')  LIKE '".$to_date1."%'" );
      }
      else
      {
       $rows_added[]=DB::select("SELECT distinct COUNT(*) AS count FROM document_folder_files WHERE document_source_type_id like '".$document_source_type_id."'and directorate_id='".$directorateid."' AND department_id='".$departmentid."' AND document_category_id='".$documenttypeid."' and active_flag='1' and DATE_FORMAT(created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(created_date,'%Y-%m-%d')  LIKE '".$to_date1."%'" );
       $rows_delete[]=DB::select("SELECT distinct COUNT(*) AS count FROM document_folder_files WHERE document_source_type_id like '".$document_source_type_id."'and  directorate_id='".$directorateid."' AND department_id='".$departmentid."' AND document_category_id='".$documenttypeid."' and active_flag='0' and DATE_FORMAT(created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(created_date,'%Y-%m-%d')  LIKE '".$to_date1."%'" );
       $rows_archive[]=DB::select("SELECT distinct COUNT(*) AS count FROM document_folder_files WHERE document_source_type_id like '".$document_source_type_id."'and directorate_id='".$directorateid."' AND department_id='".$departmentid."' AND document_category_id='".$documenttypeid."' and  active_flag='2' and DATE_FORMAT(created_date,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(created_date,'%Y-%m-%d')  LIKE '".$to_date1."%'" );
     }

   }
 }





 $rows1 = DB::table('users as a')
 ->select('a.*',)
 ->where('a.active_flag',0)
 ->get();

 $response = [
  'rows' => $rows,
  'rows_archive' => $rows_archive,
  'rows_delete'=>$rows_delete,
  'rows_added'=>$rows_added,


]; 



  // echo json_encode($rows);exit;
        // return $rows;   

$serviceResponse = array();
$serviceResponse['Code'] = config('setting.status_code.success');
$serviceResponse['Message'] = config('setting.status_message.success');
$serviceResponse['Data'] = $response;
$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
return $sendServiceResponse;
} catch(\Exception $exc){
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
public function awaiting_auth_search(Request $request)
{

  $logMethod = 'Method => ReportController => awaiting_auth_search';
  try {           
    $inputArray = $this->decryptData($request->requestData);

    // $user_id = $inputArray['user_id'];

    $from_date = $inputArray['from_date'];            
    $to_date = $inputArray['to_date'];

    





    if($from_date !=''){
      $from_date1=date('Y-m-d', strtotime($from_date)); 
    }
    else
    {
      $from_date1='';
    }
    if($to_date !=''){
      $to_date1=date('Y-m-d', strtotime($to_date)); 
    }
    else
    {
      $to_date1='';
    }
    if(($from_date !='') && ($to_date !=''))
    {


     $rows=DB::select("SELECT concat('waiting_auth','#',tsc.tasks_id) as audit_id,tsc.tasks_type,tsc.active_status,tsc.tasks_id,datediff(DATE_FORMAT(NOW(),'%Y-%m-%d'),DATE_FORMAT(tsc.created_at,'%Y-%m-%d')) AS pending_day,us.name
      FROM tasks_common_latest_level_user tsc
      INNER JOIN tasks ta ON (ta.tasks_id=tsc.tasks_id)
      INNER JOIN users us ON (us.id=tsc.allocated_user_id) WHERE ta.active_flag='0' and DATE_FORMAT(tsc.created_at,'%Y-%m-%d') >='".$from_date1."' AND date_format(tsc.created_at,'%Y-%m-%d')   <= '".$to_date1."'");




   }
   
   else
   {
    $rows=DB::select("SELECT concat('waiting_auth','#',tsc.tasks_id) as audit_id,tsc.tasks_type,tsc.active_status,tsc.tasks_id,datediff(DATE_FORMAT(NOW(),'%Y-%m-%d'),DATE_FORMAT(tsc.created_at,'%Y-%m-%d')) AS pending_day,us.name
      FROM tasks_common_latest_level_user tsc
      INNER JOIN tasks ta ON (ta.tasks_id=tsc.tasks_id)
      INNER JOIN users us ON (us.id=tsc.allocated_user_id) WHERE  ta.active_flag='0' and  DATE_FORMAT(tsc.created_at,'%Y-%m-%d') LIKE '".$from_date1."%' AND date_format(tsc.created_at,'%Y-%m-%d')  LIKE '".$to_date1."%'");

    
  }

  



  $rows1 = DB::table('users as a')
  ->select('a.*',)
  ->where('a.active_flag',0)
  ->get();

  $response = [
    'rows' => $rows,



  ]; 



  // echo json_encode($rows);exit;
        // return $rows;   

  $serviceResponse = array();
  $serviceResponse['Code'] = config('setting.status_code.success');
  $serviceResponse['Message'] = config('setting.status_message.success');
  $serviceResponse['Data'] = $response;
  $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
  $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
  return $sendServiceResponse;
} catch(\Exception $exc){
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








}
