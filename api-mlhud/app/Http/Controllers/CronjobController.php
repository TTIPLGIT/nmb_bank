<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Mail\newcoursemail;
use App\Mail\endcoursemail;
use App\Mail\gtreselectMail;
use DateTime;


class CronjobController extends BaseController
{
    public function date_difference($dateFromDB)
    {
        $today = new DateTime();
        $todayDateOnly = $today->format('Y-m-d');

        $datetime2 = new DateTime($dateFromDB);
        // Date from the database

        $dbDateOnly = $datetime2->format('Y-m-d');
        $dbDateOnly = new DateTime($dbDateOnly);
        $todayDateOnly = new DateTime($todayDateOnly);


        $interval = $dbDateOnly->diff($todayDateOnly);

        $days = $interval->format('%d');
        $month = $interval->format('%m');

        $data = [
            'days' => $days,
            'month' => $month
        ];
        return $data;
    }

    public function job_schedular(Request $request)
    {
        try {

            $method = 'Method => CronjobController => job_schedular';
            //$user_id = auth()->user()->id;
            $courses = DB::select("select * from elearning_courses where drop_course=0");
            $course_name = $courses[0]->course_name;
            $course_count_twodays = 0;
            // $this->WriteFileLog($courses);
            foreach ($courses as $key => $row) {
                # code...
                $date_difference = CronjobController::date_difference($row->course_start_period);
                if ($date_difference['days'] == 2 && $date_difference['month'] > 0) {
                    $course_count_twodays++;
                    $role_id = $row->course_category;
                    $where = $row->course_category != 0 ? " AND ur.role_id =$role_id" : "";
                    $users = DB::select("SELECT u.* from users as u inner join uam_user_roles as ur on u.id=ur.user_id where u.active_flag=0 " . $where);
                    //$this->WriteFileLog($users);
                    //$this->WriteFileLog("No of users that are going to get the email " . count($users));
                    foreach ($users as $key => $user) {
                        # code...
                        $email_id = config('setting.email_id');
                        $email = $this->getusermail($user->id);
                        $name = $this->getusername($user->id);
                        //$this->WriteFileLog("user Name" . $row->course_name);
                        $base_url = config('setting.base_url');

                        $data = array(
                            'name' => $name,
                            'email' => $email,
                            'course_name' => $row->course_name,
                            'base_url' => $base_url
                        );

                        Mail::to($data['email'])->send(new newcoursemail($data));
                        // $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                        // $role_name_fetch = $role_name[0]->role_name;
                        $this->auditLog('Cronjob_schedular', 1, 'Start Period', 'Course Start before 2 days', 1, NOW(), 'admin');

                        // $this->WriteFileLog("Email Sent");
                    }
                }
            }
            // $this->WriteFileLog("Courses that are going to be ended after 2 days-" . $course_count_twodays);
            // $this->WriteFileLog("Task Completed");
            $this->WriteFileLog("hlooo");
            $courses = DB::select("select c.* from elearning_courses as c inner join user_course_relation as uc on uc.course_id=c.course_id where c.drop_course=0 and uc.course_status='Enrolled' ");
            $course_name = $courses[0]->course_name;
            $course_count_twodays = 0;
            foreach ($courses as $key => $row) {
                $date_difference = CronjobController::date_difference($row->course_end_period);
                $this->WriteFileLog($row->course_end_period);

                $this->WriteFileLog($date_difference);
                if ($date_difference['days'] == 2 && $date_difference['month'] == 0) {
                    $this->WriteFileLog("days count :", $date_difference['days']);
                    $course_count_twodays++;
                    $role_id = $row->course_category;
                    $where = $row->course_category != 0 ? " AND ur.role_id =$role_id" : "";
                    $this->WriteFileLog($where);
                    $users = DB::select("SELECT u.* from users as u inner join uam_user_roles as ur on u.id=ur.user_id where u.active_flag=0 " . $where);
                    foreach ($users as $key => $user) {
                        # code...
                        $email_id = config('setting.email_id');
                        $email = $this->getusermail($user->id);
                        $name = $this->getusername($user->id);
                        $base_url = config('setting.base_url');

                        $data = array(
                            'name' => $name,
                            'email' => $email,
                            'course_name' => $row->course_name,
                            'base_url' => $base_url
                        );

                        Mail::to($data['email'])->send(new newcoursemail($data));
                        // $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=");
                        // $role_name_fetch = $role_name[0]->role_name;
                        $this->auditLog('Cronjob_schedular', 1 , 'End Period', 'Course End before 2 days',1, NOW(),'admin');
                    }
                }
            }
            $this->WriteFileLog("Courses that are going to be started after 2 days-" . $course_count_twodays);
            $this->WriteFileLog("Task Completed");


            // GT Counselor or Supervisor not selected to reselect message(cronjob) //


            $this->WriteFileLog("log44");

            $method = 'Method => CronjobController => job_schedular';
            //$user_id = auth()->user()->id;
            $gt_approval_process = DB::select("SELECT * from gt_approve_process where status IS null");
            $this->WriteFileLog($gt_approval_process);
            foreach ($gt_approval_process as $key => $row) {
                $created_at = new DateTime(($row->created_at));
                $this->WriteFileLog("hiii");
                $created_at = $created_at->format('Y-m-d');
                $this->WriteFileLog($created_at);
                $date_difference = CronjobController::date_difference($created_at);
                $this->WriteFileLog('hiiii');
                $this->WriteFileLog(json_encode($date_difference));
                $this->WriteFileLog('jiiiiii');
                if ($date_difference['days'] >= 14 && $date_difference['month'] >= 0) {

                    // update in the gt_approve_process againt Id


                    DB::transaction(function () use ($row) {
                        DB::table('gt_approve_process')
                            ->where('id', $row->id)
                            ->update([
                                'approval_status' => 'No Response',
                                'status' => 3
                            ]);
                    });


                    // email functionlity

                    $email = $this->getusermail($row->user_id);
                    $this->WriteFileLog("dfnjn");
                    $this->WriteFileLog(($row->id));
                    $name = $this->getusername($row->user_id);
                    $this->WriteFileLog(($row->id));
                    $base_url = config('setting.base_url');

                    $data = array(
                        'name' => $name,
                        'email' => $email,
                        'base_url' => $base_url
                    );

                    Mail::to($data['email'])->send(new gtreselectMail($data));


                    // Notification

                    $notifications = DB::table('notifications')->insertGetId([
                        'user_id' => $row->user_id,
                        'notification_status' => 'gt reselected',
                        'notification_url' => 'approvalprocess_index',
                        'megcontent' => "Professional Member No response for the Approval ReSelected the Professional Member.",
                        'alert_meg' => "Professional Member No response for the Approval ReSelected the Professional Member.",
                        'created_by' => $row->user_id,
                        'created_at' => NOW()

                    ]);
                    // $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=");
                    // $role_name_fetch = $role_name[0]->role_name;
                    $this->auditLog('gt_approve_process', 1, 'Reselect Response', 'GT Reselect after 14 days', 1, NOW(), 'admin');
                }
                
            }
            $role_name_fetch = $role_name[0]->role_name;

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] =  1;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
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
