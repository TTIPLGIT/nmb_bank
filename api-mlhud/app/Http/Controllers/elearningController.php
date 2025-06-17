<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\Redirect;
use App\Models\Event;


class elearningController extends BaseController
{
    public function dashboard(Request $request)
    {
        $method = 'Method => elearningController => dashboard';
        try {
            $userID = auth()->user()->id;

            $rows = DB::select("SELECT role_id from uam_user_roles  where user_id=$userID");
          
            $role_id = $rows[0]->role_id;
            $availablenotices = DB::select("SELECT * from elearning_noticeboard where (user_category =$role_id or user_category =0)and notice_status=0 ");
            

            $filterd_noticearry = [];
            $currentDate = date('d-m-Y');

            foreach ($availablenotices as $key => $availablenotice) {
                $noticedateString = $availablenotice->notice_date;
                $noticedate = strtotime($noticedateString);
                $convertedDate = date('d-m-Y', $noticedate);



                if ($convertedDate >= $currentDate) {
                    $convertedDate = date('d F Y', $noticedate);
                    $availablenotice->notice_date = $convertedDate;
                    $filterd_noticearry[$key] = $availablenotice;
                }
            }

            $courses_classes_all = DB::select("SELECT course_name,course_id,course_banner,course_classes,course_pay,course_instructor,course_description FROM elearning_courses WHERE (drop_course=0 and course_category =$role_id) or course_category =0");
            $duration1 = '00:00:00';
            foreach ($courses_classes_all as $key1 => $courses_classes_single) {
                $course_id = $courses_classes_single->course_id;
                $users_course_relation = DB::select("SELECT COUNT('id') as enrolled_count FROM user_course_relation WHERE course_id=$course_id");
                $single_course_enrolles_count = $users_course_relation[0]->enrolled_count;
                $course_classes = explode(',', $courses_classes_single->course_classes);
                $total_seconds = 0;
                foreach ($course_classes as $key2 => $course_class) {
                    $course_class = DB::select("SELECT class_id,class_name,class_duration FROM elearning_classes WHERE drop_class =0 AND class_id = $course_class");
                    if (count($course_class) == 0) {
                        continue;
                    }
                    $this_duration = $course_class[0]->class_duration;

                    $duration_parts = explode('.', $this_duration);
                    $minutes = intval($duration_parts[0]);

                    $seconds = intval($duration_parts[1]);

                    // Convert minutes and seconds to seconds
                    $total_seconds += $minutes * 60 + $seconds;
                }
                $hours = floor($total_seconds / 3600);
                $minutes = floor(($total_seconds % 3600) / 60);

                // Format the duration
                $formatted_duration = '';
                if ($hours > 0) {
                    $formatted_duration .= $hours . ' hours ';
                }
                if ($minutes > 0) {
                    $formatted_duration .= $minutes . ' minutes';
                }
                // $co= DB::select('SELECT COUNT(course_id) AS numberofcourses  FROM user_course_relation where course_status="Enrolled"');


                $courses_classes_all[$key1]->duration = $formatted_duration;
                $courses_classes_all[$key1]->total_student = $single_course_enrolles_count;
            }


            // $row = DB::table('elearning_noticeboard')
            //     ->select('*')
            //     ->join('users', 'users.id', '=', 'elearning_noticeboard.created_by')
            //     ->get();
            // foreach ($filterd_noticearry as $key => $rows) {
            //     $noticedateString = $rows->notice_date;
            //     $noticedate = strtotime($noticedateString);
            //     $convertedDate = date('d F Y', $noticedate);

            //     }
            $row2['course_progress'] = DB::select("SELECT COUNT(*) AS course_progress  FROM user_course_relation where user_id=$userID and course_status='Enrolled'");
            $row2['course_completed'] = DB::select("SELECT COUNT(*) AS course_completed  FROM user_course_relation WHERE user_id=$userID and course_status='Completed'");
            $row2['course_certificate'] = DB::select("SELECT COUNT(*) AS course_certificate  FROM user_course_relation WHERE user_id=$userID and get_certified=1");
            $row2['cpt_points'] = DB::select("SELECT total_cptpoints AS cpt_points  FROM users WHERE id=$userID and active_flag=0");


            $response = [
                'rows' => $filterd_noticearry,
                'dasboardCount' => $row2,
                'recomment_courses' => $courses_classes_all
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
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
    public function events_fetch(Request $request)
    {
       

        $method = 'Method => elearningController =>events_fetch';
        try {
           
            $userID = auth()->user()->id;
            // $rows = DB::select("SELECT role_id from uam_roles  where user_id=$userID");
            // $role_id=$rows[0]->role_id;
            $inputArray = $this->decryptData($request->requestData);
            
            $input = [
                'event_date' => $inputArray['event_date'],
            ];
            $event_date = $input['event_date'];
            $rows = DB::select("SELECT role_id from uam_user_roles  where user_id=$userID");
            $role_id = $rows[0]->role_id;
        
            $rows = DB::select("SELECT  * from elearning_events  where (user_category =$role_id or user_category = 0) and event_date ='$event_date' and event_status=0");
          
            // $events = Event::select('event_date')->where('event_date', '>=', now()->startOfMonth())->get();
            // $eventDates = $events->pluck('event_date')->map(function ($date) {
            //     return \Carbon\Carbon::parse($date)->format('d-m-Y'); // Format as needed
            // });
            $response = [
                'rows' => $rows,
                //'event_dates' => $eventDates,
            ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] =  $response;
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
