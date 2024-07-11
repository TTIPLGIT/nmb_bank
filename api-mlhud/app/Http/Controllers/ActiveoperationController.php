<?php
// DEEPIKA
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


class Activeoperationcontroller extends BaseController
{



  public function get_login()
  {
    try {
      $method = 'Method => ActiveopertionController => get_login';
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


  public function login_search(Request $request)
  {     
    
    $logMethod = 'Method => ActiveoperationController => login_search';
    try {
      $inputArray = $this->decryptData($request->requestData); 
      $user_id = $inputArray['user_id'];
      $from_date = $inputArray['from_date'];
      $to_date = $inputArray['to_date'];
      $process_type = $inputArray['process_type'];
      $uam_actions = $inputArray['uam_actions'];
      if ($from_date != '') {
        $from_date = date('Y-m-d', strtotime($from_date));
      } else {

        $from_date = '';
      }
      if ($to_date != '') {

        $to_date = date('Y-m-d', strtotime($to_date));
      } else {

        $to_date = $from_date;
      }

 //----- only from date
      if($from_date != ' ' &&  $user_id == null && $process_type==null && $uam_actions==null){  
        $rows = DB::select("SELECT * From audit_logs inner join users on users.id=audit_logs.user_id WHERE DATE_FORMAT(action_date_time,'%Y-%m-%d') >='".$from_date."' and DATE_FORMAT(action_date_time,'%Y-%m-%d') <='".$to_date."'" ); 
      }
//------date and user
      if($from_date != null &&  $user_id != null && $process_type==null && $uam_actions==null){  
        $rows = DB::select("Select* From audit_logs inner join users on users.id=audit_logs.user_id WHERE audit_logs.user_id=$user_id  and DATE_FORMAT(action_date_time,'%Y-%m-%d') >='".$from_date."' and DATE_FORMAT(action_date_time,'%Y-%m-%d') <='".$to_date."'" ); 
      } 
//-------users and fromdate and to date process type
      if($from_date != null && $user_id != null && $process_type != null){
        $rows = DB::select("Select * From audit_logs inner join users on users.id=audit_logs.user_id WHERE audit_logs.user_id=$user_id and audit_logs.audit_table_name LIKE '$process_type%' and DATE_FORMAT(action_date_time, '%Y-%m-%d') >='".$from_date."' and DATE_FORMAT(action_date_time,'%Y-%m-%d') <='".$to_date."'");
      }

 //-----only user name
      if ($from_date == ' ' && $to_date == ' ' && $user_id !=' ' && $process_type==' ' && $uam_actions==' ') {
        $rows = DB::select("select * from audit_logs inner join users on users.id = audit_logs.user_id where audit_logs.user_id =$user_id;");
      }
// -----process type
      if ($from_date == ' ' && $to_date == ' ' && $user_id !=' ' && $process_type != ' ' ) {
        $rows =DB::select("select * from audit_logs where audit_table_name LIKE 'uam%' and user_id =$user_id;");      }

//-----process type with actions   
   if($from_date == ' ' && $to_date == ' ' && $user_id !=' ' && $process_type != ' ' && $uam_actions != ' '){
     $rows =DB::select("select * from audit_logs inner join users on users.id=audit_logs.user_id where audit_table_name LIKE '$process_type%' and audit_action LIKE '$uam_actions%' and user_id =$user_id;"); 
   }

 
 
  




  



      $rows1 = DB::table('users as a')
        ->select('a.*',)
        ->get();

      $response = [
        'rows' => $rows,
        'rows1' => $rows1
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
}
