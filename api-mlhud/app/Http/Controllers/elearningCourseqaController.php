<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\Redirect;



class elearningCourseqaController extends BaseController
{
    public function index(Request $request)
    {
        try {
            $method = 'Method =>  elearningCourseqaController => index';



            $rows['quiz_list'] = DB::select("SELECT * FROM elearning_forum WHERE active_flag=0");

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

            //code...
        } catch (\Exception $exc) {

            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $serviceResponse = array();
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }

    public function question_delete(Request $request)
    {
        try {
            $method = 'Method => elearningCourseqaController => question_delete';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'question_id' => $inputArray['question_id'],
            ];

            $rows=DB::table('elearning_forum')
                ->where('question_id', $input['question_id'])
                ->update([
                    'active_flag' => '1',


                ]);
            $this->notifications_insert(null, auth()->user()->id, "Question Deleted Successfully", "/elearningadminqa");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_forum', $rows, 'Delete', 'Admin Question Deletion', auth()->user()->id, NOW(), $role_name_fetch);
           
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 1;
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
    public function fetch(Request $request)
    {

        try {
            $method = 'Method => elearningCourseqaController =>fetch';
            $userID = auth()->user()->id;
            // $rows = DB::select("SELECT role_id from uam_roles  where user_id=$userID");
            // $role_id=$rows[0]->role_id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'question_id' => $inputArray['question_id'],
            ];
            $id = $input['question_id'];
            // $rows = DB::select("SELECT *  from elearning_forum  where question_id =  $id ");
            $rows = DB::select("SELECT f.*,u.course_name,u.course_id FROM elearning_forum AS f inner join elearning_courses as u ON f.course_id =u.course_id WHERE question_id =  $id and f.active_flag=0");
            foreach ($rows as $key => $row) {
                $rows[$key]->question_description = strip_tags($row->question_description);
                // Use the $description variable as needed (it will contain the plain text without HTML tags)
            }
            $response = [
                'rows' => $rows,
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
    public function show(Request $request)
    {

        $method = 'Method => elearningCourseqaController => fetch';
        try {

            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $id = $request->id;
            $row = DB::table('elearning_forum')
                ->select('*')
                ->where('question_id', $id)
                ->get();

            $response = [
                'rows' => $row,
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
    public function reply_index(Request $request)
    {
        $method = 'Method =>  elearningCourseqaController => reply_index';
        try {



            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'question_id' => $inputArray['question_id'],

            ];
            $id = $input['question_id'];

            $rows['quiz_list'] = DB::select("SELECT r.*,c.course_name,c.course_id,u.name,f.question_header,cr.id as crid FROM elearningallcourses_reply as r inner join elearning_courses as c ON r.course_id =c.course_id inner join users AS u ON r.user_id =u.id inner join elearning_forum AS f ON r.question_id =f.question_id left join elearningcoursesadmin_reply AS cr ON r.id =cr.course_reply_id WHERE r.active_flag=0 and r.question_id=$id");

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

            //code...
        } catch (\Exception $exc) {

            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $serviceResponse = array();
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
    public function reply_fetch(Request $request)
    {

        try {
            $method = 'Method => elearningCourseqaController =>reply_fetch';
            $userID = auth()->user()->id;
            // $rows = DB::select("SELECT role_id from uam_roles  where user_id=$userID");
            // $role_id=$rows[0]->role_id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'question_id' => $inputArray['question_id'],
                'id' => $inputArray['id'],
                'type' => $inputArray['type'],
            ];
            $id = $input['question_id'];
            $course_reply_id = $inputArray['id'];
            // $rows = DB::select("SELECT *  from elearning_forum  where question_id =  $id ");
            $reply_details = [];
            if ($input['type'] == "reply") {
                $rows = DB::select("SELECT r.*,c.course_name,c.course_id,u.name,f.question_header,f.question_description FROM elearningallcourses_reply as r inner join elearning_courses as c ON r.course_id =c.course_id inner join users AS u ON r.user_id =u.id inner join elearning_forum AS f ON r.question_id =f.question_id WHERE r.active_flag=0 and r.id= $course_reply_id");
            }
            if ($input['type'] == "show") {
                $rows = DB::select("SELECT r.*,c.course_name,c.course_id,u.name,f.question_header,f.question_description FROM elearningallcourses_reply as r inner join elearning_courses as c ON r.course_id =c.course_id inner join users AS u ON r.user_id =u.id inner join elearning_forum AS f ON r.question_id =f.question_id WHERE r.active_flag=0 and r.id= $course_reply_id");

                $reply_details = DB::select("SELECT r.*,c.course_name,c.course_id,u.name,f.question_header,f.question_description FROM elearningcoursesadmin_reply as r  inner join elearning_courses as c ON r.course_id =c.course_id inner join users AS u ON r.user_id =u.id inner join elearning_forum AS f ON r.question_id =f.question_id WHERE r.active_flag=0 and r.course_reply_id= $course_reply_id");
            }
            // $rows = DB::select("SELECT f.*,u.course_name,u.course_id FROM elearning_forum AS f inner join elearning_courses as u ON f.course_id =u.course_id WHERE question_id =  $id and f.active_flag=0");

            foreach ($rows as $key => $row) {
                $rows[$key]->question_description = strip_tags($row->question_description);
                // Use the $description variable as needed (it will contain the plain text without HTML tags)
            }
            $response = [
                'rows' => $rows,
                'reply_details' => $reply_details
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
    public function store(Request $request)
    {

        $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
        try {
            $method = 'Method => elearningCourseqaController => store';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'question_id' => $inputArray['question_id'],
                'course_id' => $inputArray['course_id'],
                'user_id' =>  $userID,
                'reply_details' => $inputArray['reply_details'],
                'course_reply_id' => $inputArray['course_reply_id'],


            ];
            $rows=DB::transaction(function () use ($input) {
                $settings_id = DB::table('elearningcoursesadmin_reply')
                    ->insertGetId([
                        'course_reply_id' => $input['course_reply_id'],
                        'question_id' => $input['question_id'],
                        'course_id' => $input['course_id'],
                        'reply_details' => $input['reply_details'],
                        'user_id' => $input['user_id'],
                        'active_flag' => '0',
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
            });

            $this->notifications_insert(null, auth()->user()->id, "Admin Reply Added Successfully", "/reply/index/".$input['course_reply_id']);
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearningcoursesadmin_reply', $rows, 'Create', 'Admin Course Reply Creation', auth()->user()->id, NOW(), $role_name_fetch);
           

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 1;
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
    public function reply_delete(Request $request)
    {
        try {
            $method = 'Method => elearningCourseqaController => reply_delete';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],

            ];

            $rows = DB::table('elearningcoursesadmin_reply')
                ->where('id', $input['id'])
                ->update([
                    'active_flag' => '1',

                ]);

            // $rows =  DB::table('elearningallcourses_reply')
            //     ->where('id', $input['course_reply_id'])
            //     ->update([
            //         'active_flag' => '1',

            //     ]);
            $response = [
                'rows' => $rows,

            ];

            $this->notifications_insert(null, auth()->user()->id, "Admin Reply Deleted Successfully", "/reply/index");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearningcoursesadmin_reply', $rows, 'Delete', 'Admin Course Reply Delete', auth()->user()->id, NOW(), $role_name_fetch);
           

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
}
