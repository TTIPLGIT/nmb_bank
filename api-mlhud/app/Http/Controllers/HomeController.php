<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;

class HomeController extends BaseController
{
  /**
   * Schema: -
   * Table Name: claim_invoices, scanned_claim_invoices & claim_invoice_notes
   * Author: S.Anbukani
   * Date: 21/09/2019
   * Description: Dashboard view.
   */
  public function index()
  {

    $logMethod = 'Method => HomeController => Index';
    $user_id  = auth()->user()->id;
    $stakeholder_id  = auth()->user()->id;
    
    try {
      $users = DB::table('users')
        ->select('users.name', 'users.email', 'users.id', 'users.profile_image', 'users.profile_path', 'uam_user_roles.active_flag', 'uam_user_roles.role_id')
        ->join('uam_user_roles', 'uam_user_roles.user_id', '=', 'users.id')
        ->where('users.id', $user_id)
        ->orderBy('users.id', 'DESC')->first();
      $role = DB::select("SELECT role_id FROM uam_user_roles where user_id=$user_id;");
      $role = $role[0]->role_id;
     
      $progress = array();
      $response = array();

      if ($role == 30) {

        // $pending_count = DB::select("SELECT CAST(COUNT('id')/2 AS UNSIGNED) as count  from gt INNER JOIN gt_approve_process AS ga ON ga.user_id=gt.user_id where ga.status=1 and gt.active_flag=2");
        // $approved_count = DB::select("SELECT CAST(COUNT('id')/2 AS UNSIGNED) as count   from gt INNER JOIN gt_approve_process AS ga ON ga.user_id=gt.user_id where ga.status=1 and gt.active_flag=1");
        // $reject_count = DB::select("SELECT CAST(COUNT('id')/2 AS UNSIGNED) as count  from gt INNER JOIN gt_approve_process AS ga ON ga.user_id=gt.user_id where ga.status=1 and gt.active_flag=null");
        // $response['pending_count'] = ($pending_count);
        // $response['reject_count'] = ($reject_count);
        // $response['approved_count'] = ($approved_count);


        //gt//
        $pending_count_gt = DB::table('gt')
          ->select(DB::raw('count(*) as count'))
          ->join('users', 'users.id', '=', 'gt.user_id')
          ->where('gt.active_flag', 1)
          ->where('gt.status', 'Pending')
          ->get();
        $approved_count_gt =   DB::table('gt')
          ->select(DB::raw('count(*) as count'))
          ->join('users', 'users.id', '=', 'gt.user_id')
          ->where('gt.active_flag', 1)
          ->where('gt.status', 'Approved')
          ->get();
        $reject_count_gt = DB::select("SELECT CAST(COUNT('id')/2 AS UNSIGNED) as count  from gt INNER JOIN gt_approve_process AS ga ON ga.user_id=gt.user_id where ga.status=1 and gt.active_flag=null");
        $response['pending_count_gt'] = ($pending_count_gt);
        $response['reject_count_gt'] = ($reject_count_gt);
        $response['approved_count_gt'] = ($approved_count_gt);


        $response['gt_pending'] =  DB::table('gt')
          ->select('users.name as name', 'gt.interest as interest', 'users.country as country', 'gt.status as approval_status', 'gt.user_id as user_id', 'gt.user_id as approval_persons_id')
          ->join('users', 'users.id', '=', 'gt.user_id')
          ->where('gt.active_flag', 1)
          ->where('gt.status', 'Pending')
          ->get();
        $response['gt_approved'] =  DB::table('gt')
          ->select('users.name as name', 'gt.interest as interest', 'users.country as country', 'gt.status as approval_status', 'gt.user_id as user_id', 'gt.user_id as approval_persons_id')
          ->join('users', 'users.id', '=', 'gt.user_id')
          ->where('gt.active_flag', 1)
          ->where('gt.status', 'Approved')
          ->get();
        $response['gt_rejected'] =  DB::table('gt')
          ->select('users.name as name', 'gt.interest as interest', 'users.country as country', 'gt.status as approval_status', 'gt.user_id as user_id', 'gt.user_id as approval_persons_id')
          ->join('users', 'users.id', '=', 'gt.user_id')
          ->where('gt.active_flag', 1)
          ->where('gt.status', 'Rejected')
          ->get();


        $response['pending_count_nru'] = DB::table('approved_certificate')
          ->select('users.name as name', 'users.country as country', 'approved_certificate.status as status', 'approved_certificate.file_name as file_name', 'approved_certificate.file_path as file_path', 'approved_certificate.user_id as user_id', 'approved_certificate.comments as comments')
          ->join('users', 'users.id', '=', 'approved_certificate.user_id')
          ->get();

        $response['approved_count_nru'] = DB::table('approved_certificate')
          ->select('users.name as name', 'users.country as country', 'approved_certificate.status as status', 'approved_certificate.file_name as file_name', 'approved_certificate.file_path as file_path', 'approved_certificate.user_id as user_id', 'approved_certificate.comments as comments')
          ->join('users', 'users.id', '=', 'approved_certificate.user_id')
          ->get();

        $response['reject_count_nru'] = DB::table('approved_certificate')
          ->select('users.name as name', 'users.country as country', 'approved_certificate.status as status', 'approved_certificate.file_name as file_name', 'approved_certificate.file_path as file_path', 'approved_certificate.user_id as user_id', 'approved_certificate.comments as comments')
          ->join('users', 'users.id', '=', 'approved_certificate.user_id')
          ->get();

        $pending_count_nru = DB::select("SELECT CAST(COUNT('id') AS UNSIGNED) as count  from approved_certificate WHERE STATUS=0");
        $approved_count_nru = DB::select("SELECT CAST(COUNT('id') AS UNSIGNED) as count  from approved_certificate WHERE STATUS=1");
        $reject_count_nru = DB::select("SELECT CAST(COUNT('id') AS UNSIGNED) as count  from approved_certificate WHERE STATUS=2");
        $response['pending_count_nru'] = ($pending_count_nru);
        $response['reject_count_nru'] = ($reject_count_nru);
        $response['approved_count_nru'] = ($approved_count_nru);

        $response['nru_approved'] = DB::table('approved_certificate')
          ->select('users.name as name', 'users.country as country', 'approved_certificate.status as status', 'approved_certificate.file_name as file_name', 'approved_certificate.file_path as file_path', 'approved_certificate.user_id as user_id', 'approved_certificate.comments as comments')
          ->join('users', 'users.id', '=', 'approved_certificate.user_id')
          ->where('approved_certificate.status', '=', '1')
          ->get();

        $response['nru_pending'] = DB::table('approved_certificate')
          ->select('users.name as name', 'users.country as country', 'approved_certificate.status as status', 'approved_certificate.file_name as file_name', 'approved_certificate.file_path as file_path', 'approved_certificate.user_id as user_id', 'approved_certificate.comments as comments')
          ->join('users', 'users.id', '=', 'approved_certificate.user_id')
          ->where('approved_certificate.status', '=', '0')
          ->get();

        $response['nru_reject'] = DB::table('approved_certificate')
          ->select('users.name as name', 'users.country as country', 'approved_certificate.status as status', 'approved_certificate.file_name as file_name', 'approved_certificate.file_path as file_path', 'approved_certificate.user_id as user_id', 'approved_certificate.comments as comments')
          ->join('users', 'users.id', '=', 'approved_certificate.user_id')
          ->where('approved_certificate.status', '=', '2')
          ->get();
      } elseif ($role == 28) {
        $pending_count = DB::select("SELECT CAST(COUNT('id')/2 AS UNSIGNED) as count  from gt INNER JOIN gt_approve_process AS ga ON ga.user_id=gt.user_id where ga.status=1 and gt.active_flag=2");
        $approved_count = DB::select("SELECT CAST(COUNT('id')/2 AS UNSIGNED) as count   from gt INNER JOIN gt_approve_process AS ga ON ga.user_id=gt.user_id where ga.status=1 and gt.active_flag=1");
        $reject_count = DB::select("SELECT CAST(COUNT('id')/2 AS UNSIGNED) as count  from gt INNER JOIN gt_approve_process AS ga ON ga.user_id=gt.user_id where ga.status=1 and gt.active_flag=null");
        $response['pending_count_gt'] = ($pending_count);
        $response['reject_count_gt'] = ($reject_count);
        $response['approved_count_gt'] = ($approved_count);
        $response['gt_pending'] =  DB::table('gt_approve_process')
          ->select('*')
          ->join('users', 'users.id', '=', 'gt_approve_process.user_id')
          ->join('gt', 'gt.user_id', '=', 'gt_approve_process.user_id')
          ->where('gt_approve_process.approval_persons_id', $user_id)
          ->where('approval_status', 'Pending')
          ->get();
        $response['gt_approved'] =  DB::table('gt_approve_process')
          ->select('*')
          ->join('users', 'users.id', '=', 'gt_approve_process.user_id')
          ->join('gt', 'gt.user_id', '=', 'gt_approve_process.user_id')
          ->where('gt_approve_process.approval_persons_id', $user_id)
          ->where('approval_status', 'Approved')
          ->get();
        $response['gt_rejected'] =  DB::table('gt_approve_process')
          ->select('*')
          ->join('users', 'users.id', '=', 'gt_approve_process.user_id')
          ->join('gt', 'gt.user_id', '=', 'gt_approve_process.user_id')
          ->where('gt_approve_process.approval_persons_id', $user_id)
          ->where('approval_status', 'Rejected')
          ->get();
        $response['pending_count_gt'] =  DB::table('gt_approve_process')
          ->select(DB::raw('count(*) as count'))
          ->join('users', 'users.id', '=', 'gt_approve_process.user_id')
          ->join('gt', 'gt.user_id', '=', 'gt_approve_process.user_id')
          ->where('gt_approve_process.approval_persons_id', $user_id)
          ->where('approval_status', 'Pending')
          ->get();

        $response['approved_count_gt'] = DB::table('gt_approve_process')
          ->select(DB::raw('count(*) as count'))
          ->join('users', 'users.id', '=', 'gt_approve_process.user_id')
          ->join('gt', 'gt.user_id', '=', 'gt_approve_process.user_id')
          ->where('gt_approve_process.approval_persons_id', $user_id)
          ->where('approval_status', 'Approved')
          ->get();
        $response['reject_count_gt'] = DB::table('gt_approve_process')
          ->select(DB::raw('count(*) as count'))
          ->join('users', 'users.id', '=', 'gt_approve_process.user_id')
          ->join('gt', 'gt.user_id', '=', 'gt_approve_process.user_id')
          ->where('gt_approve_process.approval_persons_id', $user_id)
          ->where('approval_status', 'Rejected')
          ->get();
      } elseif ($role == 29) {
        //data fetch
        $response['gt_pending'] =  DB::table('gt_approve_process')
          ->select('*')
          ->join('users', 'users.id', '=', 'gt_approve_process.user_id')
          ->join('gt', 'gt.user_id', '=', 'gt_approve_process.user_id')
          ->where('gt_approve_process.approval_persons_id', $user_id)
          ->where('approval_status', 'Pending')
          ->get();

        $response['gt_approved'] =  DB::table('gt_approve_process')
          ->select('*')
          ->join('users', 'users.id', '=', 'gt_approve_process.user_id')
          ->join('gt', 'gt.user_id', '=', 'gt_approve_process.user_id')
          ->where('gt_approve_process.approval_persons_id', $user_id)
          ->where('approval_status', 'Approved')
          ->get();
        $response['gt_rejected'] =  DB::table('gt_approve_process')
          ->select('*')
          ->join('users', 'users.id', '=', 'gt_approve_process.user_id')
          ->join('gt', 'gt.user_id', '=', 'gt_approve_process.user_id')
          ->where('gt_approve_process.approval_persons_id', $user_id)
          ->where('approval_status', 'Rejected')
          ->get();
        $response['pending_count_gt'] =  DB::table('gt_approve_process')
          ->select(DB::raw('count(*) as count'))
          ->join('users', 'users.id', '=', 'gt_approve_process.user_id')
          ->join('gt', 'gt.user_id', '=', 'gt_approve_process.user_id')
          ->where('gt_approve_process.approval_persons_id', $user_id)
          ->where('approval_status', 'Pending')
          ->get();

        $response['approved_count_gt'] = DB::table('gt_approve_process')
          ->select(DB::raw('count(*) as count'))
          ->join('users', 'users.id', '=', 'gt_approve_process.user_id')
          ->join('gt', 'gt.user_id', '=', 'gt_approve_process.user_id')
          ->where('gt_approve_process.approval_persons_id', $user_id)
          ->where('approval_status', 'Approved')
          ->get();
        $response['reject_count_gt'] = DB::table('gt_approve_process')
          ->select(DB::raw('count(*) as count'))
          ->join('users', 'users.id', '=', 'gt_approve_process.user_id')
          ->join('gt', 'gt.user_id', '=', 'gt_approve_process.user_id')
          ->where('gt_approve_process.approval_persons_id', $user_id)
          ->where('approval_status', 'Rejected')
          ->get();
        $reject_count = DB::select("SELECT CAST(COUNT('id')/2 AS UNSIGNED) as count  from gt INNER JOIN gt_approve_process AS ga ON ga.user_id=gt.user_id where ga.status=1 and gt.active_flag=null");
      } elseif ($role == 23) {
        $pending_count_firm = DB::select("SELECT  CAST(COUNT('id') AS UNSIGNED) as count  from firm_registration WHERE STATUS=0");
        $approved_count_firm = DB::select("SELECT  CAST(COUNT('id') AS UNSIGNED) as count  from firm_registration WHERE STATUS=1");
        $reject_count_firm = DB::select("SELECT  CAST(COUNT('id') AS UNSIGNED) as count  from firm_registration WHERE STATUS=2");
        $response['pending_countfirm'] = ($pending_count_firm);
        $response['reject_countfirm'] = ($reject_count_firm);
        $response['approved_countfirm'] = ($approved_count_firm);

        $response['cgv_approve_count'] = DB::select("SELECT * from firm_registration where  firm_registration.status = 1 order by status ASC");
        $response['cgv_pending_count'] = DB::select("SELECT * from firm_registration where   firm_registration.status = 0 order by status ASC");
        $response['cgv_reject_count'] = DB::select("SELECT * from firm_registration where   firm_registration.status =  2 order by status ASC");
      } elseif ($role == 34) {

        $response['pending_count_gt']  = DB::table('gt')
        ->select(DB::raw('count(*) as count'))
        ->join('users', 'users.id', '=', 'gt.user_id')
        ->where('gt.active_flag', 1)
        ->where('users.id', $user_id)
        ->where('gt.status', 'Pending')
        ->get();

        $response['approved_count_gt'] =   DB::table('gt')
        ->select(DB::raw('count(*) as count'))
        ->join('users', 'users.id', '=', 'gt.user_id')
        ->where('gt.active_flag', 1)
        ->where('users.id', $user_id)
        ->where('gt.status', 'Approved')
        ->get();
        
        $response['reject_count_gt'] = DB::select("SELECT CAST(COUNT('id')/2 AS UNSIGNED) as count  from gt INNER JOIN gt_approve_process AS ga ON ga.user_id=gt.user_id where ga.status=1 and gt.active_flag=null");
       

        $response['gt_pending'] =  DB::table('gt')
        ->select('users.name as name', 'gt.interest as interest', 'users.country as country', 'gt.status as approval_status', 'gt.user_id as user_id', 'gt.user_id as approval_persons_id')
        ->join('users', 'users.id', '=', 'gt.user_id')
        ->where('gt.active_flag', 1)
        ->where('users.id', $user_id)
        ->where('gt.status', 'Pending')
        ->get();
      $response['gt_approved'] =  DB::table('gt')
        ->select('users.name as name', 'gt.interest as interest', 'users.country as country', 'gt.status as approval_status', 'gt.user_id as user_id', 'gt.user_id as approval_persons_id')
        ->join('users', 'users.id', '=', 'gt.user_id')
        ->where('gt.active_flag', 1)
        ->where('users.id', $user_id)
        ->where('gt.status', 'Approved')
        ->get();
      $response['gt_rejected'] =  DB::table('gt')
        ->select('users.name as name', 'gt.interest as interest', 'users.country as country', 'gt.status as approval_status', 'gt.user_id as user_id', 'gt.user_id as approval_persons_id')
        ->join('users', 'users.id', '=', 'gt.user_id')
        ->where('gt.active_flag', 1)
        ->where('gt.status', 'Rejected')
        ->get();
        
        $response['pending_count_professional']=DB::select("SELECT COUNT(*) AS total ,task_name,type, valuer_id,inst_description,stakeholder_id,a.status,a.stakeholder_comment,a.valuer_comment,name
        FROM instruction_details AS a 
        INNER JOIN users AS b ON a.valuer_id=b.id  WHERE valuer_id= $user_id and a.status ='0'
        GROUP BY valuer_id, stakeholder_id,task_name,type,inst_description,stakeholder_comment,valuer_comment,status
        order by task_name desc");

        $response['inprogress_count_professional']=DB::select("SELECT COUNT(*) AS total ,task_name,type, valuer_id,inst_description,stakeholder_id,a.status,a.stakeholder_comment,a.valuer_comment,name
        FROM instruction_details AS a 
        INNER JOIN users AS b ON a.valuer_id=b.id  WHERE valuer_id= '$user_id' and a.status ='1'
        GROUP BY valuer_id, stakeholder_id,task_name,type,inst_description,stakeholder_comment,valuer_comment,status
        order by task_name desc");

        $response['completed_count_professional']=DB::select("SELECT COUNT(*) AS total ,task_name,type, valuer_id,inst_description,stakeholder_id,a.status,a.stakeholder_comment,a.valuer_comment,name
        FROM instruction_details AS a 
        INNER JOIN users AS b ON a.valuer_id=b.id  WHERE valuer_id= '$user_id' and a.status ='2'
        GROUP BY valuer_id, stakeholder_id,task_name,type,inst_description,stakeholder_comment,valuer_comment,status
         order by task_name desc");

        $response['license'] = DB::select("SELECT license_number, renewal_date, valuer_type FROM  professional_member_licence WHERE user_id = $user_id");
        $response['license_count'] = DB::select("SELECT count(*) FROM  professional_member_licence WHERE user_id = $user_id");
        
        $response['firm_count'] = DB::select("SELECT a.id,a.firm_name, b.partner_id FROM firm_registration AS a INNER JOIN firm_partners AS b ON a.id = b.firm_id WHERE b.partner_id = $user_id;");

      }


      // NRU //
      elseif ($role == 35) {


        $response['pending_count_nru'] = DB::table('approved_certificate')
          ->select('users.name as name', 'users.country as country', 'approved_certificate.status as status', 'approved_certificate.user_id as user_id', 'approved_certificate.comments as comments')
          ->join('users', 'users.id', '=', 'approved_certificate.user_id')
          ->get();

        $response['approved_count_nru'] = DB::table('approved_certificate')
          ->select('users.name as name', 'users.country as country', 'approved_certificate.status as status', 'approved_certificate.user_id as user_id', 'approved_certificate.comments as comments')
          ->join('users', 'users.id', '=', 'approved_certificate.user_id')
          ->get();

        $response['reject_count_nru'] = DB::table('approved_certificate')
          ->select('users.name as name', 'users.country as country', 'approved_certificate.status as status', 'approved_certificate.user_id as user_id', 'approved_certificate.comments as comments')
          ->join('users', 'users.id', '=', 'approved_certificate.user_id')
          ->get();

        $pending_count_nru = DB::select("SELECT CAST(COUNT('id') AS UNSIGNED) as count  from approved_certificate WHERE STATUS=0");
        $approved_count_nru = DB::select("SELECT CAST(COUNT('id') AS UNSIGNED) as count  from approved_certificate WHERE STATUS=1");
        $reject_count_nru = DB::select("SELECT CAST(COUNT('id') AS UNSIGNED) as count  from approved_certificate WHERE STATUS=2");
        $response['pending_count_nru'] = ($pending_count_nru);
        $response['reject_count_nru'] = ($reject_count_nru);
        $response['approved_count_nru'] = ($approved_count_nru);

        $response['nru_approved'] = DB::table('approved_certificate')
          ->select('users.name as name', 'users.country as country', 'approved_certificate.status as status', 'approved_certificate.user_id as user_id', 'approved_certificate.comments as comments')
          ->join('users', 'users.id', '=', 'approved_certificate.user_id')
          ->get();

        $response['nru_pending'] = DB::table('approved_certificate')
          ->select('users.name as name', 'users.country as country', 'approved_certificate.status as status', 'approved_certificate.user_id as user_id', 'approved_certificate.comments as comments')
          ->join('users', 'users.id', '=', 'approved_certificate.user_id')
          ->get();

        $response['nru_reject'] = DB::table('approved_certificate')
          ->select('users.name as name', 'users.country as country', 'approved_certificate.status as status', 'approved_certificate.user_id as user_id', 'approved_certificate.comments as comments')
          ->join('users', 'users.id', '=', 'approved_certificate.user_id')
          ->get();

        $progress['gen'] = DB::select("SELECT * FROM user_general_details where active_flag='0' and user_id=$user_id;");
        $progress['edu']  = DB::select("SELECT * FROM user_education_dip_details where user_id=$user_id;");
        $progress['exp'] = DB::select("SELECT * FROM user_exp_wrq_details where active_flag='0' and user_id=$user_id;");
        $progress['gt_process'] = DB::select("SELECT * FROM approved_certificate where user_id=$user_id and status=1;");
        $progress['localadaptaion_test'] = DB::select("SELECT *FROM elearning_userlocaladaptation WHERE user_id = $user_id AND result = 'PASS';");
        

      } elseif ($role == 27) {
        $progress['gen'] = DB::select("SELECT * FROM user_general_details where  active_flag='0' and user_id=$user_id;");
        $progress['edu']  = DB::select("SELECT * FROM user_education_dip_details where  user_id=$user_id;");
        $progress['exp'] = DB::select("SELECT * FROM user_exp_wrq_details where active_flag='0' and user_id=$user_id;");
        $progress['gt_approveprocess'] = DB::select("SELECT * FROM gt_approve_process where user_id=$user_id and status=1;");
        $progress['ethics_test'] = DB::select("SELECT * FROM elearning_userethnic WHERE user_id = $user_id AND result = 'PASS';");
        
        

      } elseif ($role == 31 || $role == 32 || $role == 36) {
        // data count //
        $progress = DB::select("SELECT COUNT(*) AS count, a.id, a.stakeholder_id, a.task_name, a.type, 
            CASE WHEN a.firm_id IS NOT NULL THEN f.firm_name ELSE b.name END AS name, 
            a.status, a.cgv_approval, a.stakeholder_comment 
           FROM instruction_details AS a  
           LEFT JOIN users AS b ON (a.firm_id IS NULL AND a.valuer_id = b.id) OR (a.firm_id IS NOT NULL AND a.firm_id = b.id) 
           LEFT JOIN firm_registration AS f ON a.firm_id = f.user_id 
           WHERE a.stakeholder_id = $user_id 
         GROUP BY a.valuer_id, a.stakeholder_id, a.task_name, a.status, a.id, a.cgv_approval, name, firm_name;
     ");
        $progress = DB::select("SELECT COUNT(*) AS count, a.id, a.stakeholder_id, a.task_name, a.type, 
      CASE WHEN a.firm_id IS NOT NULL THEN f.firm_name ELSE b.name END AS name, 
      a.status, a.cgv_approval, a.stakeholder_comment 
     FROM instruction_details AS a  
     LEFT JOIN users AS b ON (a.firm_id IS NULL AND a.valuer_id = b.id) OR (a.firm_id IS NOT NULL AND a.firm_id = b.id) 
     LEFT JOIN firm_registration AS f ON a.firm_id = f.user_id 
     WHERE a.stakeholder_id = $user_id 
   GROUP BY a.valuer_id, a.stakeholder_id, a.task_name, a.status, a.id, a.cgv_approval, name, firm_name;
");

        $progress = DB::select("SELECT COUNT(*) AS count, a.id, a.stakeholder_id, a.task_name, a.type, 
CASE WHEN a.firm_id IS NOT NULL THEN f.firm_name ELSE b.name END AS name, 
a.status, a.cgv_approval, a.stakeholder_comment 
FROM instruction_details AS a  
LEFT JOIN users AS b ON (a.firm_id IS NULL AND a.valuer_id = b.id) OR (a.firm_id IS NOT NULL AND a.firm_id = b.id) 
LEFT JOIN firm_registration AS f ON a.firm_id = f.user_id 
WHERE a.stakeholder_id = $user_id 
GROUP BY a.valuer_id, a.stakeholder_id, a.task_name, a.status, a.id, a.cgv_approval, name, firm_name;
");
        // data fetch //

        $progress['complete_count']  = DB::select("SELECT COUNT(*) AS count, a.id, a.stakeholder_id, a.task_name, a.type, 
CASE WHEN a.firm_id IS NOT NULL THEN f.firm_name ELSE b.name END AS name, 
a.status, a.cgv_approval, a.stakeholder_comment 
FROM instruction_details AS a  
LEFT JOIN users AS b ON (a.firm_id IS NULL AND a.valuer_id = b.id) OR (a.firm_id IS NOT NULL AND a.firm_id = b.id) 
LEFT JOIN firm_registration AS f ON a.firm_id = f.user_id 
WHERE a.stakeholder_id = $user_id  and a.status ='3'
GROUP BY a.valuer_id, a.stakeholder_id, a.task_name, a.status, a.id, a.cgv_approval, name, firm_name;
");
        $progress['inprogress_count']  = DB::select("SELECT COUNT(*) AS count, a.id, a.stakeholder_id, a.task_name, a.type, 
CASE WHEN a.firm_id IS NOT NULL THEN f.firm_name ELSE b.name END AS name, 
a.status, a.cgv_approval, a.stakeholder_comment 
FROM instruction_details AS a  
LEFT JOIN users AS b ON (a.firm_id IS NULL AND a.valuer_id = b.id) OR (a.firm_id IS NOT NULL AND a.firm_id = b.id) 
LEFT JOIN firm_registration AS f ON a.firm_id = f.user_id 
WHERE a.stakeholder_id = $user_id  and a.status ='0'
GROUP BY a.valuer_id, a.stakeholder_id, a.task_name, a.status, a.id, a.cgv_approval, name, firm_name;
");

        $progress['resend_count']  = DB::select("SELECT COUNT(*) AS count, a.id, a.stakeholder_id, a.task_name, a.type, 
CASE WHEN a.firm_id IS NOT NULL THEN f.firm_name ELSE b.name END AS name, 
a.status, a.cgv_approval, a.stakeholder_comment 
FROM instruction_details AS a  
LEFT JOIN users AS b ON (a.firm_id IS NULL AND a.valuer_id = b.id) OR (a.firm_id IS NOT NULL AND a.firm_id = b.id) 
LEFT JOIN firm_registration AS f ON a.firm_id = f.user_id 
WHERE a.stakeholder_id = $user_id and a.status =4
GROUP BY a.valuer_id, a.stakeholder_id, a.task_name, a.status, a.id, a.cgv_approval, name, firm_name;
");
      } else {
        $pending_count = DB::select("SELECT COUNT('id') as count from gt_approve_process where gt_approve_process.approval_persons_id=$user_id and STATUS=NULL");
        $approved_count = DB::select("SELECT COUNT('id') as count from gt_approve_process where gt_approve_process.approval_persons_id=$user_id and STATUS='1'");
        $reject_count = DB::select("SELECT COUNT('id') as count from gt_approve_process where gt_approve_process.approval_persons_id=$user_id and STATUS='2'");
        $response['pending_count'] = ($pending_count);
        $response['reject_count'] = ($reject_count);
        $response['approved_count'] = ($approved_count);
      }



      $response['users'] = ($users);

      $response['progress'] = ($progress);

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
}
