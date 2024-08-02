<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
use File;
use Illuminate\Support\Str;
use Log;
use Illuminate\Support\Facades\DB;



class AuditLogController extends BaseController
{

  public function login_index()
  {
    $permission_data = $this->FillScreensByUserScreen();
    $screen_permission = $permission_data[0];
    if (strpos($screen_permission['permissions'], 'View') !== false) {
      try {

        $user_id = '';
        $from_date = '';
        $to_date = '';





        $method = 'Method => AuditlogController => index';
        $gatewayURL = config('setting.api_gateway_url') . '/auditlog/login';
        $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
        $response = json_decode($response);
        if ($response->Status == 200 && $response->Success) {
          $objData = json_decode($this->decryptData($response->Data));
          if ($objData->Code == 200) {
            $data2 = json_decode(json_encode($objData->Data), true);

            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('auditlog.login.index', compact('modules', 'screens', 'from_date', 'user_id', 'to_date', 'data2'));
          }
        } else {
          $objData = json_decode($this->decryptData($response->Data));
          echo json_encode($objData->Code);
          exit;
        }
      } catch (\Exception $exc) {
        echo $exc;
        return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
      }
    } else {
      return redirect()->route('not_allow');
    }
  }
  public function get_data()
  {
    try {
      $method = 'Method => AuditLogController => get_data';
      // $rows = DB::table('operations_audit_logs as a')
      // ->select('a.*','users.name')
      // ->join('users', 'users.id', '=', 'a.user_id')
      // ->get();
      $rows1 = DB::table('users as a')
        ->select('a.*',)

        ->get();
      $rows = [];
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
    } catch (\Exception $exc) {
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
      $method = 'Method => AuditLogController => get_login';
      // $rows = DB::table('operations_audit_logs as a')
      // ->select('a.*','users.name')
      // ->join('users', 'users.id', '=', 'a.user_id')
      // ->get();
      $rows1 = DB::table('users as a')
        ->select('a.*',)

        ->get();
      $rows = [];
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
    } catch (\Exception $exc) {
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

    $logMethod = 'Method => ClaimInvoiceSearchController => Index';
    try {
      $inputArray = $this->decryptData($request->requestData);

      $user_id = $inputArray['user_id'];

      $receipt_no = $inputArray['receipt_no'];
      $received_for = $inputArray['received_for'];

      $source_type = $inputArray['source_type']; //return $name;
      $uam_action = $inputArray['uam_action'];
      $workflow_action = $inputArray['workflow_action'];
      $form_action = $inputArray['form_action'];


      $rows = array();
      if ($receipt_no != '') {
        $receipt_no1 = date('Y-m-d', strtotime($receipt_no));
      } else {
        $receipt_no1 = '';
      }
      if ($received_for != '') {
        $receipt_no2 = date('Y-m-d', strtotime($received_for));
      } else {
        $receipt_no2 = '';
      }
      if (((($user_id != '') && ($source_type == '')) && (($receipt_no != '') && ($received_for != ''))) && ($source_type == '')) {
        $rows = DB::select("SELECT us.name,'Document Process' AS module_name,fa.status_desc AS ACTION,date_format(fa.process_date,'%d-%m-%Y & %h:%i:%s') AS action_date,fa.role_name FROM formprocessing_audit AS fa INNER JOIN users us ON (us.id=fa.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
                WHERE DATE_FORMAT(fa.process_date,'%Y-%m-%d') >='" . $receipt_no1 . "' AND date_format(fa.process_date,'%Y-%m-%d')   <= '" . $receipt_no2 . "' and us.email LIKE '" . $user_id . "%'
                UNION ALL
                SELECT us.name,'Workflow' AS module_name,wa.audit_action AS action,date_format(wa.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,wa.role_name FROM operations_audit_logs AS wa 
                INNER JOIN users us ON (us.id=wa.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
                WHERE DATE_FORMAT(wa.action_date_time,'%Y-%m-%d') >='" . $receipt_no1 . "' AND date_format(wa.action_date_time,'%Y-%m-%d')   <= '" . $receipt_no2 . "' and us.email LIKE '" . $user_id . "%'
                UNION ALL
                SELECT us.name,'UAM' AS module_name,Al.description as ACTION,date_format(Al.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,Al.role_name  FROM audit_logs Al INNER JOIN users us on(us.id=al.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
                WHERE DATE_FORMAT(Al.action_date_time,'%Y-%m-%d') >='" . $receipt_no1 . "' AND date_format(Al.action_date_time,'%Y-%m-%d')   <= '" . $receipt_no2 . "' and us.email LIKE '" . $user_id . "%'");
      } else if (((($user_id != '') && ($source_type == '')) || (($receipt_no != '') xor ($received_for != ''))) && ($source_type == '')) {
        $rows = DB::select("SELECT us.name,'Document Process' AS module_name,fa.status_desc AS ACTION,date_format(fa.process_date,'%d-%m-%Y & %h:%i:%s') AS action_date,fa.role_name FROM formprocessing_audit AS fa INNER JOIN users us ON (us.id=fa.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
                WHERE date_format(fa.process_date,'%Y-%m-%d') LIKE '" . $receipt_no1 . "%' and date_format(fa.process_date,'%Y-%m-%d') LIKE '" . $receipt_no2 . "%' and us.email LIKE '" . $user_id . "%'
                UNION ALL
                SELECT us.name,'Workflow' AS module_name,wa.audit_action AS action,date_format(wa.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,wa.role_name FROM operations_audit_logs AS wa 
                INNER JOIN users us ON (us.id=wa.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
                WHERE date_format(wa.action_date_time,'%Y-%m-%d') LIKE '" . $receipt_no1 . "%'  and date_format(wa.action_date_time,'%Y-%m-%d') LIKE '" . $receipt_no2 . "%' and us.email LIKE '" . $user_id . "%'
                UNION ALL
                SELECT us.name,'UAM' AS module_name,Al.description as ACTION,date_format(Al.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,Al.role_name  FROM audit_logs Al INNER JOIN users us on(us.id=al.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
                WHERE date_format(Al.action_date_time,'%Y-%m-%d') LIKE '" . $receipt_no1 . "%' and date_format(Al.action_date_time,'%Y-%m-%d') LIKE '" . $receipt_no2 . "%' and us.email LIKE '" . $user_id . "%'");
      } else if (($source_type != '') && (($receipt_no != '') xor ($received_for != ''))) {

        if ($source_type == 'Document Process') {


          $rows = DB::select("SELECT us.name,'Document Process' AS module_name,fa.status_desc AS ACTION,date_format(fa.process_date,'%d-%m-%Y & %h:%i:%s') AS action_date,fa.role_name FROM formprocessing_audit AS fa INNER JOIN users us ON (us.id=fa.user_id)
                  INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)WHERE date_format(fa.process_date,'%Y-%m-%d') LIKE '" . $receipt_no1 . "%'  and us.email LIKE '" . $user_id . "%' and date_format(fa.process_date,'%Y-%m-%d') LIKE '" . $receipt_no2 . "%' and fa.status_desc LIKE '" . $form_action . "%' ");
        }
        if ($source_type == 'Work Flow') {

          $rows = DB::select("
                  SELECT us.name,'Workflow' AS module_name,wa.audit_action AS ACTION,date_format(wa.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,wa.role_name FROM operations_audit_logs AS wa 
                  INNER JOIN users us ON (us.id=wa.user_id)
                  INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)WHERE date_format(wa.action_date_time,'%Y-%m-%d') LIKE '" . $receipt_no1 . "%'  and date_format(wa.action_date_time,'%Y-%m-%d') LIKE '" . $receipt_no2 . "%' and us.email LIKE '" . $user_id . "%' and wa.audit_action LIKE '" . $workflow_action . "%' 
                  ");
        }
        if ($source_type == 'UAM') {


          $rows = DB::select("SELECT us.name,'UAM' AS module_name,Al.description as ACTION,date_format(Al.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,Al.role_name  FROM audit_logs Al INNER JOIN users us on(us.id=al.user_id)
                 INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)WHERE date_format(Al.action_date_time,'%Y-%m-%d') LIKE '" . $receipt_no1 . "%'  and us.email LIKE '" . $user_id . "%' and date_format(Al.action_date_time,'%Y-%m-%d') LIKE '" . $receipt_no2 . "%' and Al.description LIKE '" . $uam_action . "%' ");
        }
      } else if (($source_type != '') && ($receipt_no != '') && ($received_for != '')) {

        if ($source_type == 'Document Process') {


          $rows = DB::select("SELECT us.name,'Document Process' AS module_name,fa.status_desc AS ACTION,date_format(fa.process_date,'%d-%m-%Y & %h:%i:%s') AS action_date,fa.role_name FROM formprocessing_audit AS fa INNER JOIN users us ON (us.id=fa.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)WHERE DATE_FORMAT(fa.process_date,'%Y-%m-%d') >='" . $receipt_no1 . "' AND date_format(fa.process_date,'%Y-%m-%d')   <= '" . $receipt_no2 . "' and us.email LIKE '" . $user_id . "%' and fa.status_desc LIKE '" . $form_action . "%' ");
        }
        if ($source_type == 'Work Flow') {

          $rows = DB::select("
                SELECT us.name,'Workflow' AS module_name,wa.audit_action AS ACTION,date_format(wa.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,wa.role_name FROM operations_audit_logs AS wa 
                INNER JOIN users us ON (us.id=wa.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)WHERE  DATE_FORMAT(wa.action_date_time,'%Y-%m-%d') >='" . $receipt_no1 . "' AND date_format(wa.action_date_time,'%Y-%m-%d')   <= '" . $receipt_no2 . "' and us.email LIKE '" . $user_id . "%' and wa.audit_action LIKE '" . $workflow_action . "%' 
                ");
        }
        if ($source_type == 'UAM') {


          $rows = DB::select("SELECT us.name,'UAM' AS module_name,Al.description as ACTION,date_format(Al.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,Al.role_name  FROM audit_logs Al INNER JOIN users us on(us.id=al.user_id)
               INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)WHERE DATE_FORMAT(Al.action_date_time,'%Y-%m-%d') >='" . $receipt_no1 . "' AND date_format(Al.action_date_time,'%Y-%m-%d')   <= '" . $receipt_no2 . "'  and us.email LIKE '" . $user_id . "%' and Al.description LIKE '" . $uam_action . "%' ");
        }
      } else if ((($source_type == '') && (($receipt_no != '') && ($received_for != ''))) && ($source_type == '')) {
        $rows = DB::select("SELECT us.name,'Document Process' AS module_name,fa.status_desc AS ACTION,date_format(fa.process_date,'%d-%m-%Y & %h:%i:%s') AS action_date,fa.role_name FROM formprocessing_audit AS fa INNER JOIN users us ON (us.id=fa.user_id)
              INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
              WHERE DATE_FORMAT(fa.process_date,'%Y-%m-%d') >='" . $receipt_no1 . "' AND date_format(fa.process_date,'%Y-%m-%d')   <= '" . $receipt_no2 . "' and us.email LIKE '" . $user_id . "%'
              UNION ALL
              SELECT us.name,'Workflow' AS module_name,wa.audit_action AS action,date_format(wa.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,wa.role_name FROM operations_audit_logs AS wa 
              INNER JOIN users us ON (us.id=wa.user_id)
              INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
              WHERE DATE_FORMAT(wa.action_date_time,'%Y-%m-%d') >='" . $receipt_no1 . "' AND date_format(wa.action_date_time,'%Y-%m-%d')   <= '" . $receipt_no2 . "' and us.email LIKE '" . $user_id . "%'
              UNION ALL
              SELECT us.name,'UAM' AS module_name,Al.description as ACTION,date_format(Al.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,Al.role_name  FROM audit_logs Al INNER JOIN users us on(us.id=al.user_id)
              INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)
              WHERE DATE_FORMAT(Al.action_date_time,'%Y-%m-%d') >='" . $receipt_no1 . "' AND date_format(Al.action_date_time,'%Y-%m-%d')   <= '" . $receipt_no2 . "' and us.email LIKE '" . $user_id . "%'");
      } else if (($source_type != '')) {

        if ($source_type == 'Document Process') {


          $rows = DB::select("SELECT us.name,'Document Process' AS module_name,fa.status_desc AS ACTION,date_format(fa.process_date,'%d-%m-%Y & %h:%i:%s') AS action_date,fa.role_name FROM formprocessing_audit AS fa INNER JOIN users us ON (us.id=fa.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)WHERE date_format(fa.process_date,'%Y-%m-%d') LIKE '" . $receipt_no1 . "%'  and us.email LIKE '" . $user_id . "%' and date_format(fa.process_date,'%Y-%m-%d') LIKE '" . $receipt_no2 . "%' and fa.status_desc LIKE '" . $form_action . "%' ");
        }
        if ($source_type == 'Work Flow') {

          $rows = DB::select("
                SELECT us.name,'Workflow' AS module_name,wa.audit_action AS ACTION,date_format(wa.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,wa.role_name FROM operations_audit_logs AS wa 
                INNER JOIN users us ON (us.id=wa.user_id)
                INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)WHERE date_format(wa.action_date_time,'%Y-%m-%d') LIKE '" . $receipt_no1 . "%'  and date_format(wa.action_date_time,'%Y-%m-%d') LIKE '" . $receipt_no2 . "%' and us.email LIKE '" . $user_id . "%' and wa.audit_action LIKE '" . $workflow_action . "%' 
                ");
        }
        if ($source_type == 'UAM') {


          $rows = DB::select("SELECT us.name,'UAM' AS module_name,Al.description as ACTION,date_format(Al.action_date_time,'%d-%m-%Y & %h:%i:%s') AS action_date,Al.role_name  FROM audit_logs Al INNER JOIN users us on(us.id=al.user_id)
               INNER JOIN uam_roles ro ON(ro.role_id=us.array_roles)WHERE date_format(Al.action_date_time,'%Y-%m-%d') LIKE '" . $receipt_no1 . "%'  and us.email LIKE '" . $user_id . "%' and date_format(Al.action_date_time,'%Y-%m-%d') LIKE '" . $receipt_no2 . "%' and Al.description LIKE '" . $uam_action . "%' ");
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

  public function login_search(Request $request)
  {

    $logMethod = 'Method => AuditLogController => login_search';
    try {
      $inputArray = $this->decryptData($request->requestData);
      $user_id = $inputArray['user_id'];


      $from_date = $inputArray['from_date'];
      $to_date = $inputArray['to_date'];





      if ($from_date != null) {
        $from_date = date('Y-m-d', strtotime($from_date));
      } else {
        $from_date = '';
      }
      if ($to_date != null) {
        $to_date = date('Y-m-d', strtotime($to_date));
      } else {
        $to_date = $from_date;
      }

      if ($user_id != null) {
        $rows = DB::select("SELECT * from login_audit inner join users  on login_audit.user_id=users.id where login_audit.user_id=$user_id");
      }
      $this->WriteFileLog($rows);


      if ($from_date != '' && $user_id != null) {
        // $rows = DB::select("SELECT * From login_audit inner join users on users.id=login_audit.user_id WHERE DATE_FORMAT(login_time,'%Y-%m-%d') >='".$from_date."' and DATE_FORMAT(login_time,'%Y-%m-%d') <='".$to_date."'" ); 
        $from_date = empty($from_date) ? '1970-01-01' : date('Y-m-d', strtotime($from_date));
        $to_date = empty($to_date) ? '9999-12-31' : date('Y-m-d', strtotime($to_date));

        // Query to fetch records within the date range while handling empty dates.
        $rows = DB::select("SELECT * FROM login_audit
                             INNER JOIN users ON login_audit.user_id = users.id
                             WHERE DATE(login_time) >= IFNULL('$from_date', '1970-01-01')
                             AND DATE(login_time) <= IFNULL('$to_date', '9999-12-31') AND login_audit.user_id = $user_id");
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
    } catch (\Exception $exc) {
      $exceptionResponse = array();
      $exceptionResponse['ServiceMethod'] = $logMethod;
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


  public function user_id(Request $request)
  {
    try {
      $method = 'Method => AuditLogController => user_id';
      $inputArray = $this->decryptData($request->requestData);
      $input = [
        'user_id' => $inputArray['user_id'],
      ];
      $user_id = $input['user_id'];


      $rows = DB::table('operations_audit_logs as a')
        ->select('a.*', 'users.name')
        ->join('users', 'users.id', '=', 'a.user_id')
        ->where('a.user_id', $user_id)
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
    } catch (\Exception $exc) {
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
