<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\If_;
use DateTime;
use DateInterval;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\coursecreationmail;
use App\Mail\regenerateMail;

class tryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // class start //

    public function class_store(Request $request)
    {

        try {
            $method = 'Method => add class => class_store';
            $inputArray = $request->requestData;
            $user_id = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];

            $resource_extension = explode(".", $inputArray['resource_name']);
            $resource_extension = $resource_extension[1];


            $input = [
                'class_name' => $inputArray['class_name'],
                'resource_name' => $inputArray['resource_name'],
                'resource_path' => $inputArray['resource_path'],
                'class_format' => $resource_extension,
                'class_duration' => $inputArray['class_duration'],
                'class_description' => $inputArray['class_description'],
                'quiz_id' => $inputArray['quiz_id'],
                'class_quiz' => $inputArray['class_quiz'],

            ];

            $update_id = DB::transaction(function () use ($input) {
                $role_id = DB::table('elearning_classes')
                    ->insertGetId([
                        'class_name' => $input['class_name'],
                        'resource_name' => $input['resource_name'],
                        'resource_path' => $input['resource_path'],
                        'class_duration' => $input['class_duration'],
                        'class_format' => $input['class_format'],
                        'class_description' => $input['class_description'],
                        'quiz_id' => $input['quiz_id'],
                        'class_quiz' => $input['class_quiz'],

                    ]);
            });

            $this->notifications_insert(null, auth()->user()->id, $input['class_name'] . " Class Name has been Created Successfully", "/admincourse");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_classes', $update_id, 'Create', 'Class Creation', auth()->user()->id, NOW(), $role_name_fetch);

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


    public function index(Request $request)
    {
        $logMethod = 'Method => nrvController => User';
        try {
            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $rows = array();
            $rows['rows'] = DB::table('elearning_classes')
                ->select('*')
                ->where('drop_class', 0)
                ->get();


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $rows;
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


    public function class_delete(Request $request)
    {

        try {

            $method = 'Method => tryController => class_delete';
            $inputArray = $request['requestData'];
            $userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];


            $id = $inputArray['class_id'];
            // Copy code
            // Assuming $inputArray['class_id'] is an array of class IDs
            $class_ids = $inputArray['class_id'];

            // Ensure that $class_ids is an array before proceeding
            if (!is_array($class_ids)) {
                // If $class_ids is a string, convert it to an array using explode()
                $class_ids = explode(",", $class_ids);
            }

            // Trim each element in the array to remove any leading/trailing whitespaces
            $class_ids = array_map('trim', $class_ids);

            // Sanitize the class IDs to prevent SQL injection (assuming they are integers)
            $sanitized_class_ids = array_map('intval', $class_ids);

            // Convert the class_ids array into a comma-separated string
            $comma_separated_class_ids = implode(", ", $sanitized_class_ids);
            // Run the query to retrieve course information for each class ID
            $course_mapping = DB::select("SELECT * FROM elearning_courses WHERE FIND_IN_SET(course_classes, '$comma_separated_class_ids') > 0 AND drop_course = 0");
            // Add the result to the course_mappings array
            // $course_mappings = $course_mapping;

            if (!empty($course_mapping)) {
                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.exception');
                $serviceResponse['Message'] = "depend";
                $quiz_type = (!empty($course_mapping) ? "Course" : "");

                $serviceResponse['response_message'] =  "This Class have Dependency on the " . $quiz_type;
                $this->WriteFileLog($serviceResponse);

                $serviceResponse['Data'] = 0;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);

                return $sendServiceResponse;
            } else {
                $update_id = DB::table('elearning_classes')
                    ->where('class_id', $id)
                    ->update([
                        'drop_class' => '1',

                    ]);
                $message = "Class Deleted Successfully";


                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => auth()->user()->id,
                    'notification_status' => 'Class Details Deleted',
                    'notification_url' => 'admincourse',
                    'megcontent' => "Class Deleted Successfully .",
                    'alert_meg' => "Class details Deleted Successfully .",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);

                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                $role_name_fetch = $role_name[0]->role_name;
                $this->auditLog('elearning_classes', $update_id, 'Delete', 'Class Deletion', auth()->user()->id, NOW(), $role_name_fetch);
                $this->notifications_insert(null, auth()->user()->id, "Class Deleted Successfully", "/class/index");
            }
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 1;
            $serviceResponse['response_message'] = $message;
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

    public function class_show(Request $request)
    {

        $method = 'Method => tryController => class_show';
        try {

            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $class_id = $request->class_id;
            $row = DB::table('elearning_classes')
                ->select('*')
                ->where('class_id', $class_id)
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

    public function class_fetch(Request $request)
    {

        $method = 'Method => tryController =>class_fetch';
        try {

            $userID = auth()->user()->class_id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'class_id' => $inputArray['class_id'],
            ];
            $class_id = $input['class_id'];

            $rows = DB::select("SELECT class_id,class_description,class_name,class_duration,resource_name,resource_path,class_quiz,quiz_id,CONCAT(resource_path,'/',resource_name) AS full_notice_path from elearning_classes   where class_id =  $class_id ");
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


    public function class_edit($class_id)
    {
        try {
            $method = 'Method => tryController =>edit';
            $class_id = $this->decryptData($class_id);
            $row = DB::table('elearning_classes')
                ->select('*')
                ->where('class_id', $class_id)
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
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
    public function class_update(Request $request)
    {
        //

        try {
            $method = 'Method => tryController => update';
            $inputArray = $this->decryptData($request->requestData);
            if ($inputArray['class_quiz'] == 'no') {
                $inputArray['quiz_id'] = 0;
            }
            $input = [

                'class_name' => $inputArray['class_name'],
                'class_description' => $inputArray['class_description'],
                'resource_name' => $inputArray['resource_name'],
                'class_duration' => $inputArray['class_duration'],
                'class_quiz' => $inputArray['class_quiz'],
                'quiz_id' => $inputArray['quiz_id'],
                'eid' => $inputArray['eid'],

            ];

            $update_id = DB::table('elearning_classes')
                ->where('class_id', $input['eid'])
                ->update([
                    'class_name' => $input['class_name'],
                    'class_description' => $input['class_description'],
                    'resource_name' => $input['resource_name'],
                    'class_duration' => $input['class_duration'],
                    'class_quiz' => $input['class_quiz'],
                    'quiz_id' => $input['quiz_id'],


                ]);
            $this->notifications_insert(null, auth()->user()->id, "Class Updated Successfully", "/class/index");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_classes', $update_id, 'Update', 'Class Updation', auth()->user()->id, NOW(), $role_name_fetch);


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


    // Noticeboard start //

    public function notice_store(Request $request)
    {

        try {
            $method = 'Method => tryController => notice_store';
            $inputArray = $request->requestData;
            $user_id = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];


            $input = [
                'notice_name' => $inputArray['notice_name'],
                'notice_banner' => $inputArray['notice_banner'],
                'notice_path' => $inputArray['notice_path'],
                'notice_date' => $inputArray['notice_date'],
                'notice_author' => $inputArray['notice_author'],
            ];

            DB::transaction(function () use ($input) {
                $role_id = DB::table('elearning_noticeboard')
                    ->insertGetId([
                        'notice_name' => $input['notice_name'],
                        'notice_banner' => $input['notice_banner'],
                        'notice_path' => $input['notice_path'],
                        'notice_date' => $input['notice_date'],
                        'notice_author' => $input['notice_author'],
                        'created_at' => NOW(),
                        'updated_at' => NOW()

                    ]);
            });

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

    public function notice_list(Request $request)
    {
        $logMethod = 'Method => tryController => notice_list';
        try {
            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $rows = array();
            $rows['rows'] = DB::table('elearning_noticeboard')
                ->select('*')
                ->where('notice_status', 0)
                ->get();


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $rows;
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



    public function notice_delete(Request $request)
    {

        try {

            $method = 'Method => tryController => notice_delete';
            $inputArray = $request['requestData'];
            $userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];


            $id = $inputArray['notice_id'];
            $uelid = DB::table('elearning_noticeboard')
                ->where('notice_id', $id)
                ->update([
                    'notice_status' => '1',

                ]);



            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Noticeboard Details Deleted',
                'notification_url' => 'adminnoticeboard',
                'megcontent' => "Noticeboard details Deleted Successfully .",
                'alert_meg' => "Noticeboard details Deleted Successfully .",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_noticeboard', $userID, 'Delete', 'Admin Noticeboard Deleted Successfully', $inputArray['user_id'], NOW(), $role_name_fetch);


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

    // Event Start //

    public function event_store(Request $request)
    {

        try {
            $method = 'Method => tryController => event_store';
            $inputArray = $request->requestData;
            $user_id = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];


            $input = [
                'event_name' => $inputArray['event_name'],
                'event_image' => $inputArray['event_image'],
                'event_date' => $inputArray['event_date'],

            ];

            DB::transaction(function () use ($input) {
                $role_id = DB::table('elearning_events')
                    ->insertGetId([
                        'event_name' => $input['event_name'],
                        'event_image' => $input['event_image'],
                        'event_date' => $input['event_date'],
                        'created_at' => NOW(),
                        'updated_at' => NOW()
                    ]);
            });

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


    public function event_list(Request $request)
    {
        $logMethod = 'Method => tryController => event_list';
        try {
            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $rows = array();
            $rows['rows'] = DB::table('elearning_events')
                ->select('*')
                ->where('event_status', 0)
                ->get();


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $rows;
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


    public function event_delete(Request $request)
    {

        try {

            $method = 'Method => tryController => event_delete';
            $inputArray = $request['requestData'];
            $userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];


            $id = $inputArray['event_id'];
            $uelid = DB::table('elearning_events')
                ->where('event_id', $id)
                ->update([
                    'event_status' => '1',

                ]);





            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Event Details Deleted',
                'notification_url' => 'adminevent',
                'megcontent' => "Event details Deleted Successfully .",
                'alert_meg' => "Event details Deleted Successfully .",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_events', $userID, 'Delete', 'Admin Event Deleted Successfully', $inputArray['user_id'], NOW(), $role_name_fetch);


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

    // Quiz Start


    public function quiz_store(Request $request)
    {

        try {
            $method = 'Method => tryController => quiz_store';
            $inputArray = $request->requestData;
            $user_id = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];


            $input = [
                'quiz_name' => $inputArray['quiz_name'],
                'quiz_questions' => $inputArray['quiz_questions'],

            ];

            DB::transaction(function () use ($input) {
                $role_id = DB::table('elearning_practice_quiz')
                    ->insertGetId([
                        'quiz_name' => $input['quiz_name'],
                        'quiz_questions' => $input['quiz_questions'],
                        'created_at' => NOW(),
                        'updated_at' => NOW()
                    ]);
            });

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


    public function quiz_list(Request $request)
    {
        $logMethod = 'Method => tryController => quiz_list';
        try {
            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $rows = array();
            $rows['rows'] = DB::table('elearning_practice_quiz')
                ->select('*')
                ->where('drop_quiz', 0)
                ->get();


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $rows;
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


    //course preview start //

    public function coursepreview(Request $request)
    {

        $logMethod = 'Method => tryController => coursepreview';
        try {
            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $courses_classes_all = DB::select('SELECT course_name,course_id,course_banner,course_classes,course_pay,course_instructor FROM elearning_courses WHERE drop_course=0');

            $duration1 = '00:00:00';
            foreach ($courses_classes_all as $key1 => $courses_classes_single) {
                $course_id = $courses_classes_single->course_id;
                $users_course_relation = DB::select("SELECT COUNT('id') as enrolled_count FROM user_course_relation WHERE course_id=$course_id");
                $single_course_enrolles_count = $users_course_relation[0]->enrolled_count;
                // $co= DB::select('SELECT COUNT(course_id) AS numberofcourses  FROM user_course_relation where course_status="Enrolled"');
                $courses_classes_all[$key1]->total_student = $single_course_enrolles_count;
            }

            $rows = array();
            $rows['elearning_courses'] = $courses_classes_all;


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $rows;
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

    // Course Start//

    public function course_store(Request $request)
    {

        try {
            $method = 'Method => add course => course_store';
            $inputArray = $request->requestData;
            $this->WritefileLog($method);
            $user_id = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];

            $course_tags =  $inputArray['course_tags'];
            $course_tags_name = implode(", ", $course_tags);

            $course_skills_required =  $inputArray['course_skills_required'];
            $course_skills_required_name = implode(", ", $course_skills_required);

            $course_gain_skills =  $inputArray['course_gain_skills'];
            $course_gain_skills_name = implode(", ", $course_gain_skills);

            $course_classes =  $inputArray['course_classes'];
            $course_classes_name = implode(", ", $course_classes);
            $introduction_extension = explode(".", $inputArray['course_introduction']);
            $introduction_extension = $introduction_extension[1];
            $userIdsString = implode(",",  $inputArray['user_ids']);

          


            $input = [
                'course_banner' => $inputArray['course_banner'],
                // 'course_summary' => $inputArray['course_summary'],
                'course_name' => $inputArray['course_name'],
                'course_instructor' => $inputArray['course_instructor'],

                'course_start_period' => $inputArray['course_start_period'],
                'course_end_period' => $inputArray['course_end_period'],
                'course_pay' => $inputArray['course_pay'],

                'course_price' => $inputArray['course_price'],
                'course_description' => $inputArray['course_description'],
                'course_description' => $inputArray['course_description'],
                'course_certificate' => $inputArray['course_certificate'],
                'course_exam' => $inputArray['course_exam'],
                'course_noperiod' => $inputArray['course_noperiod'],
                'course_introduction' => $inputArray['course_introduction'],
                'introduction_path' => $inputArray['introduction_path'],
                // 'summary_path' => $inputArray['summary_path'],
                'banner_path' => $inputArray['banner_path'],

                'course_tags' => $course_tags_name,
                'course_skills_required' => $course_skills_required_name,
                'course_gain_skills' => $course_gain_skills_name,

                'course_classes' => $course_classes_name,
                'course_cpt_points' => $inputArray['course_cpt_points'],

                'course_category' => $inputArray['course_category'],
                'role_id' => $inputArray['role_id'],
                'designation_id' => $inputArray['designation_id'],
                'user_ids' => $userIdsString,

                'course_format' => $introduction_extension,
                'examname' => $inputArray['examname'],
                'exam_date' => $inputArray['exam_date'],
                'pass_percentage' => $inputArray['pass_percentage'],
                'examname' => $inputArray['examname'],
                'cetificate_template' => $inputArray['cetificate_template'],
                'certificate_expiry' => $inputArray['certificate_expiry'],
                'course_expiry_period' => $inputArray['course_expiry_period'],
                'expired_course_id' => $inputArray['expired_course_id'],
                'expiry_input' => $inputArray['expiry_input'],
                'expiry_type' => $inputArray['expiry_type'],
                'restricted_access' => $inputArray['restricted_access'],
                'course_pin' => $inputArray['course_pin'],

            ];
          

            // dd("welcome");

            $update_id = DB::transaction(function () use ($input) {
                return DB::table('elearning_courses')
                    ->insertGetId([
                        'course_banner' => $input['course_banner'],
                        // 'course_summary' => $input['course_summary'],
                        'course_name' => $input['course_name'],
                        'course_instructor' => $input['course_instructor'],
                        'exam_id' => $input['examname'],
                        'exam_date' => $input['exam_date'],
                        'course_noperiod' => $input['course_noperiod'],
                        'pass_percentage' => $input['pass_percentage'],
                        'course_start_period' => $input['course_start_period'],
                        'course_end_period' => $input['course_end_period'],
                        'course_pay' => $input['course_pay'],

                        'course_price' => $input['course_price'],
                        'course_description' => $input['course_description'],
                        'course_certificate' => $input['course_certificate'],
                        'course_exam' => $input['course_exam'],
                        'course_introduction' => $input['course_introduction'],
                        // 'summary_path' => $input['summary_path'],
                        'introduction_path' => $input['introduction_path'],
                        'banner_path' => $input['banner_path'],

                        'course_tags' => $input['course_tags'],
                        'course_skills_required' => $input['course_skills_required'],
                        'course_gain_skills' => $input['course_gain_skills'],

                        'course_classes' => $input['course_classes'],
                        'course_cpt_points' => $input['course_cpt_points'],
                        'course_category' => $input['course_category'],
                        'course_format' => $input['course_format'],
                        'cetificate_template' => $input['cetificate_template'],
                        'certificate_expiry' => $input['certificate_expiry'],
                        'course_expiry_period' => $input['course_expiry_period'],
                        'expired_course_id' => $input['expired_course_id'],

                        'course_category' => $input['course_category'],
                        'role_id' => $input['role_id'],
                        'designation_id' => $input['designation_id'],
                        'user_ids' => $input['user_ids'],
                        'expiry_type' => $input['expiry_type'],
                        'expiry_input' => $input['expiry_input'],
                        'restricted_access' => $input['restricted_access'],
                        'course_pin' => $input['course_pin'],
                        'course_pin_created_at' => now(),






                    ]);
            });

            // $this->notifications_insert(null, auth()->user()->id, $inputArray['course_name'] . " Course Created Successfully", "/admincourse");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_courses', $update_id, 'Create', 'Course Creation', auth()->user()->id, NOW(), $role_name_fetch);

            $userIds = explode(',', $input['user_ids']);

            $users = DB::table('users')
                ->whereIn('id', $userIds)
                ->select('id', 'email', 'name')
                ->get();
            foreach ($users as $user) {


                Mail::to($user->email)->send(
                    new coursecreationmail([
                        'name'       => $user->name,
                        'course_pin' => $input['course_pin'],
                        'course_name' => $input['course_name'],
                    ])
                );
                 $this->notifications_insert(null, $user->id, "{$inputArray['course_name']} course has been allocated to you.", "/elearningquestion");
            }
 

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 1;
            $serviceResponse['course_id'] = $update_id;
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

    public function course_list(Request $request)
    {
        $logMethod = 'Method => tryController => course_list';
        try {
            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $rows1 = array();
            $rows2['rows2'] = DB::table('elearning_courses')
                ->select('*')
                ->where('drop_course', 0)
                ->get();

            $rows2['course_category'] = array(
                'Student' => config('setting.roles.Student'),
                'Teacher' => config('setting.roles.Teacher'),
                'All' => 0
            );



            $response = [
                'rows1' => $rows1,
                'rows2' => $rows2,
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
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();

            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }

    public function course_delete(Request $request)
    {

        try {

            $method = 'Method => tryController => course_delete';
            $inputArray = $request['requestData'];
            $userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];



            $id = $inputArray['course_id'];
            $coursemapping = DB::select("SELECT *  from user_class_relation  where course_id =$id");

            if (!empty($coursemapping)) {
                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.exception');
                $serviceResponse['Message'] = "depend";
                $quiz_type = (!empty($coursemapping) ? "Enrolled" :  "");
                $serviceResponse['response_message'] =  "This Course have Dependency on the " . $quiz_type;
                $serviceResponse['Data'] = 0;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
                return $sendServiceResponse;
            } else {

                $uelid = DB::table('elearning_courses')
                    ->where('course_id', $id)
                    ->update([
                        'drop_course' => '1',

                    ]);

                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => auth()->user()->id,
                    'notification_status' => 'Course Details Deleted',
                    'notification_url' => 'Registration',
                    'megcontent' => "Course details Deleted Successfully .",
                    'alert_meg' => "Course details Deleted Successfully .",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);
                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                $role_name_fetch = $role_name[0]->role_name;
                $this->auditLog('elearning_courses', $uelid, 'Delete', 'Admin Course Deleted Successfully', auth()->user()->id, NOW(), $role_name_fetch);
                // $this->auditLog('elearning_classes', $update_id, 'Delete', 'Class Deletion', auth()->user()->id, NOW(), $role_name_fetch);

                $this->notifications_insert(null, auth()->user()->id, "Course Deleted Successfully", "/class/index");
            }

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

    public function course_copy(Request $request)
    {

        try {

            $method = 'Method => tryController => course_copy';
            $inputArray = $request['requestData'];
            $userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];



            $id = $inputArray['course_id'];
            $course_expiry_period = $inputArray['course_expiry_period'];
            $certificate_expiry = $inputArray['certificate_expiry'];


            $originalCourse = DB::table('elearning_courses')->where('course_id', $id)->first();

            if ($originalCourse) {

                $newCourseData = (array) $originalCourse;

                unset($newCourseData['course_id']);

                $newCourseData['expired_course_id'] = $id;
                $newCourseData['course_expiry_period'] = $course_expiry_period;
                $newCourseData['certificate_expiry'] = $certificate_expiry;

                $newCourseId = DB::table('elearning_courses')->insertGetId($newCourseData);
            }

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Course Details Copied',
                'notification_url' => 'Registration',
                'megcontent' => "Course details Copied Successfully .",
                'alert_meg' => "Course details Copied Successfully .",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_courses', $uelid, 'Copy', 'Admin Course Copied Successfully', auth()->user()->id, NOW(), $role_name_fetch);
            // $this->auditLog('elearning_classes', $update_id, 'Delete', 'Class Deletion', auth()->user()->id, NOW(), $role_name_fetch);

            $this->notifications_insert(null, auth()->user()->id, "Course Copied Successfully", "/class/index");


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

    public function course_show(Request $request)
    {

        $method = 'Method => tryController => course_show';
        try {

            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $course_id = $request->course_id;
            $row['elearning_courses'] = DB::table('elearning_courses')
                ->select('*')
                ->where('course_id', $course_id)
                ->get();


            $course = $row['elearning_courses'];

            $userIds = [];
            if ($course && !empty($course->user_ids)) {
                $userIds = explode(',', $course->user_ids);
            }

            $row['users'] = DB::table('users')
                ->select('*')
                ->whereIn('id', $userIds)
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

    public function course_fetch(Request $request)
    {

        try {
            $method = 'Method => tryController =>cou    rse_fetch';
            $userID = auth()->user()->course_id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'course_id' => $inputArray['course_id'],
                'type' => $inputArray['type'],
            ];
            $course_id = $input['course_id'];
            $this->WriteFileLog($course_id);
            $rows = DB::select("SELECT pass_percentage,exam_id,exam_date,course_exam,course_id,course_category,course_name,course_instructor,course_banner,banner_path,course_start_period,course_end_period,course_pay,course_price,course_description,course_certificate,course_introduction,introduction_path,course_format,course_tags,course_skills_required,course_gain_skills,course_classes,course_cpt_points,CONCAT(banner_path,'/',course_banner) AS banner_path1, CONCAT(introduction_path,'/',course_introduction) AS introduction_path1,cetificate_template,course_expiry_period,certificate_expiry,role_id,designation_id,user_ids from elearning_courses  where course_id =$course_id");

            $elearning_course = DB::table('elearning_courses')
                ->join('users', 'users.id', '=', 'elearning_courses.user_ids')
                ->select('elearning_courses.*', 'users.name as user_name')
                ->where('elearning_courses.course_id', $course_id)
                ->orderBy('elearning_courses.course_id', 'desc')
                ->get();



            $response = [
                'rows' => $rows,
                'elearning_course' => $elearning_course
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

    public function course_edit($course_id)
    {
        try {
            $method = 'Method => tryController =>course_edit';
            $course_id = $this->decryptData($course_id);
            $row = DB::table('elearning_courses')
                ->select('*')
                ->where('course_id', $course_id)
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
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
    public function course_update(Request $request)
    {
        //

        try {

            $method = 'Method => tryController => course_update';
            $inputArray = $this->decryptData($request->requestData);

            
            $input = [

                'course_edit' => $inputArray['course_edit'],

                'course_category' => $inputArray['course_category'],
                'course_name' => $inputArray['course_name'],
                'course_instructor' => $inputArray['course_instructor'],

                'course_start_period' => $inputArray['course_start_period'],
                'course_end_period' => $inputArray['course_end_period'],

                'course_pay' => $inputArray['course_pay'],
                'course_price' => $inputArray['course_price'],

                'course_description' => $inputArray['course_description'],
                'course_certificate' => $inputArray['course_certificate'],
                'course_exam' => $inputArray['course_exam'],
                'course_noperiod' => $inputArray['course_noperiod'],

                // ✅ ARRAY → STRING
                'course_tags' => implode(',', (array) ($inputArray['course_tags'] ?? [])),
                'course_skills_required' => implode(',', (array) ($inputArray['course_skills_required'] ?? [])),
                'course_gain_skills' => implode(',', (array) ($inputArray['course_gain_skills'] ?? [])),
                'course_classes' => implode(',', (array) ($inputArray['course_classes'] ?? [])),

                'course_cpt_points' => $inputArray['course_cpt_points'],

                // ✅ EXAM
                'examname' => $inputArray['examname'],
                'exam_date' => $inputArray['exam_date'],
                'pass_percentage' => $inputArray['pass_percentage'],

                // ✅ CERTIFICATE
                'cetificate_template' => $inputArray['cetificate_template'],
                'certificate_expiry' => $inputArray['certificate_expiry'],
                'course_expiry_period' => $inputArray['course_expiry_period'],
                // 'expired_course_id' => $inputArray['expired_course_id'],

                // ✅ FILES
                'course_banner' => $inputArray['course_banner'],
                'course_introduction' => $inputArray['course_introduction'],
                // 'course_summary' => $inputArray['course_summary'],
                'banner_path' => $inputArray['banner_path'],
                'introduction_path' => $inputArray['introduction_path'],
                // 'summary_path' => $inputArray['summary_path'],

                // ✅ ACCESS CONTROL
                'role_id' => implode(',', (array) ($inputArray['role_id'] ?? [])),
                'designation_id' => implode(',', (array) ($inputArray['designation_id'] ?? [])),
                'user_ids' => implode(',', (array) ($inputArray['user_ids'] ?? [])),

                // ✅ EXPIRY
                'expiry_type' => $inputArray['expiry_type'],
                'expiry_input' => $inputArray['expiry_input'],
                'restricted_access' => $inputArray['restricted_access'],

                // ✅ PIN
                'course_pin' => $inputArray['course_pin'],
                'course_pin_created_at' => $inputArray['course_pin_created_at'],
            ];

            DB::table('elearning_courses')
                ->where('course_id', $input['course_edit'])
                ->update([

                    'course_banner' => $input['course_banner'],
                    // 'course_summary' => $input['course_summary'],
                    'course_name' => $input['course_name'],
                    'course_instructor' => $input['course_instructor'],

                    'exam_id' => $input['examname'],
                    'exam_date' => $input['exam_date'],

                    'course_noperiod' => $input['course_noperiod'],
                    'pass_percentage' => $input['pass_percentage'],

                    'course_start_period' => $input['course_start_period'],
                    'course_end_period' => $input['course_end_period'],

                    'course_pay' => $input['course_pay'],
                    'course_price' => $input['course_price'],

                    'course_description' => $input['course_description'],
                    'course_certificate' => $input['course_certificate'],
                    'course_exam' => $input['course_exam'],

                    'course_introduction' => $input['course_introduction'],

                    // 'summary_path' => $input['summary_path'],
                    'introduction_path' => $input['introduction_path'],
                    'banner_path' => $input['banner_path'],

                    // 🔥 ARRAY FIELDS (IMPORTANT)
                    'course_tags' => implode(',', (array) $input['course_tags']),
                    'course_skills_required' => implode(',', (array) $input['course_skills_required']),
                    'course_gain_skills' => implode(',', (array) $input['course_gain_skills']),
                    'course_classes' => implode(',', (array) $input['course_classes']),

                    'course_cpt_points' => $input['course_cpt_points'],
                    'course_category' => $input['course_category'],
                    'course_format' => $input['course_format'] ?? null,

                    'cetificate_template' => $input['cetificate_template'],
                    'certificate_expiry' => $input['certificate_expiry'],
                    'course_expiry_period' => $input['course_expiry_period'],
                    // 🔥 ACCESS CONTROL
                    'role_id' => implode(',', (array) $input['role_id']),
                    'designation_id' => implode(',', (array) $input['designation_id']),
                    'user_ids' => implode(',', (array) $input['user_ids']),

                    'expiry_type' => $input['expiry_type'],
                    'expiry_input' => $input['expiry_input'],
                    'restricted_access' => $input['restricted_access'],

                    // optional (only if needed)
                    'course_pin' => $input['course_pin'] ?? null,
                    'course_pin_created_at' => $input['course_pin_created_at'],

                    'drop_course' => '0',
                ]);

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



    //********* END */
    public function admindashboard(Request $request)
    {

        $method = 'Method => tryController => admindashboard';
        try {

            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $id = $request->id;

            $row2['total_course'] = DB::select('SELECT COUNT(course_id) AS numberofcourses  FROM elearning_courses where drop_course=0');
            $row2['free_course'] = DB::select('SELECT COUNT(course_id) AS numberofcourses  FROM elearning_courses WHERE course_price="0" and drop_course=0');
            $row2['paid_course'] = DB::select('SELECT COUNT(course_id) AS numberofcourses  FROM elearning_courses WHERE course_price>"0" and drop_course=0');
            $row2['restricted_access'] = DB::select('SELECT COUNT(course_id) AS numberofcourses  FROM elearning_courses WHERE restricted_access=1 and drop_course=0');
            $row2['certificate_course'] = DB::select('SELECT COUNT(course_id) AS numberofcourses  FROM elearning_courses WHERE course_certificate=1 and drop_course=0');
            $row2['Not_certificate_course'] = DB::select('SELECT COUNT(course_id) AS numberofcourses  FROM elearning_courses WHERE course_certificate=2 and drop_course=0');
            $row2['event_date'] = DB::select('SELECT STR_TO_DATE(event_date, "%d-%m-%Y") as event_date FROM elearning_events WHERE STR_TO_DATE(event_date, "%d-%m-%Y") >= CURDATE()');

            $courses_classes_all = DB::select('SELECT course_name,course_id,course_banner,course_classes,course_pay,course_instructor,course_description FROM elearning_courses WHERE drop_course=0');

            $duration1 = '00:00:00';
            foreach ($courses_classes_all as $key1 => $courses_classes_single) {
                $course_id = $courses_classes_single->course_id;
                $users_course_relation = DB::select("SELECT COUNT('id') as enrolled_count FROM user_course_relation WHERE course_id=$course_id");
                $single_course_enrolles_count = $users_course_relation[0]->enrolled_count;
                $course_classes = explode(',', $courses_classes_single->course_classes);
                $total_seconds = 0;
                foreach ($course_classes as $key2 => $course_class) {
                    $course_class = DB::select("SELECT class_id,class_name,class_duration FROM elearning_classes WHERE drop_class =0 AND class_id = $course_class ");
                    if (count($course_class) == 0) {
                        continue;
                    }
                    $this_duration = $course_class[0]->class_duration;

                    $duration_parts = explode('.', $this_duration);

                    $minutes = intval($duration_parts[0] ?? 0);
                    $seconds = intval($duration_parts[1] ?? 0);


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


                $courses_classes_all[$key1]->duration = $formatted_duration;
                $courses_classes_all[$key1]->total_student = $single_course_enrolles_count;
            }

            $row = DB::table('elearning_noticeboard')
                ->select('*')
                ->join('users', 'users.id', '=', 'elearning_noticeboard.created_by')
                ->where('notice_status', 0)
                ->get();

            $response = [
                'rows' => $row,
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

        try {
            $method = 'Method => tryController =>events_fetch';
            $userID = auth()->user()->id;
            // $rows = DB::select("SELECT role_id from uam_roles  where user_id=$userID");
            // $role_id=$rows[0]->role_id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'event_date' => $inputArray['event_date'],
            ];
            $event_date = $input['event_date'];

             $event_date = $input['event_date'];
            $rows = DB::select("SELECT role_id from uam_user_roles  where user_id=$userID");
            $role_id = $rows[0]->role_id;

            if (!empty($event_date) && $event_date != 'undefined' && $event_date != 'null') {
                // Return events for specific date
                $rows = DB::select("SELECT * from elearning_events  
            WHERE event_status = 0 
            AND event_date = '$event_date'");
            } else {
                // Return ALL events (for initial load)
                $rows = DB::select("SELECT * from elearning_events  
            WHERE event_status = 0 
            ORDER BY event_date DESC");
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
    public function allcourse(Request $request)
    {
        $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];

        $courses = DB::table('elearning_courses as c')
            ->leftJoin('user_course_relation as ucr', function ($join) use ($userID) {
                $join->on('c.course_id', '=', 'ucr.course_id')
                    ->where('ucr.user_id', '=', $userID);
            })
            ->leftJoin('certificate_templates as ct', 'c.course_certificate', '=', 'ct.certificate_templates_id')
            ->leftJoin('users as u', 'u.id', '=', 'ucr.user_id')
            ->where('c.drop_course', 0)
            ->whereRaw("FIND_IN_SET(?, c.user_ids)", [$userID])
            ->select(
                'c.*',  // keep all course fields
                'ucr.course_progress',
                // new certificate fields
                'ct.certificate_templates_id as ct_id',
                'ct.template_name',
                'ct.file_name',
                'ct.company_name',
                'ct.logo',
                'ct.active_flag',
                'ct.created_at as ct_created_at',
                'ct.updated_at as ct_updated_at',
                DB::raw("
                CASE 
                    WHEN ct.certificate_templates_id IS NOT NULL 
                         AND ucr.course_progress = 100 
                    THEN CONCAT('/userdocuments/certificate/', u.id, '/', c.course_id, '/certificate.pdf') 
                    ELSE NULL 
                END as certificate_url
            ")
            )
            ->get();

        $result = ['list' => $courses];

        $serviceResponse = [
            'Code'    => config('setting.status_code.success'),
            'Message' => config('setting.status_message.success'),
            'Data'    => $result
        ];

        return $this->SendServiceResponse(
            json_encode($serviceResponse, JSON_FORCE_OBJECT),
            config('setting.status_code.success'),
            true,
            true
        );
    }
    public function get_class_data(Request $request)
    {
        try {
            $method = 'Method => ElearningQuestionController => get_class_data';
            $inputArray = $this->decryptData($request->requestData);
            $classId = $inputArray['class_id'];

            $classData = DB::table('elearning_classes')
                ->where('class_id', $classId)
                ->select(
                    'class_id',
                    'class_name',
                    'class_description',
                    'resource_name',
                    'resource_path',
                    'class_duration',
                    'class_quiz',
                    'quiz_id',
                    'version_major',
                    'version_minor',
                    'is_active'
                )
                ->first();

            if (!$classData) {
                throw new \Exception('Class not found');
            }

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $classData;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            return $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
        } catch (\Exception $exc) {
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            return $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
        }
    }

    public function class_update_with_version(Request $request)
    {
        try {
            $method = 'Method => tryController => class_update_with_version';
            $inputArray = $this->decryptData($request->requestData);

            // Handle quiz selection
            if ($inputArray['class_quiz'] == 'no') {
                $inputArray['quiz_id'] = 0;
            }

            $classId = $inputArray['eid'];
            $versionType = $inputArray['version_type'] ?? 'none';
            $changeNotes = $inputArray['change_notes'] ?? '';

            // Begin transaction
            DB::beginTransaction();

            // Get current class data from database (ALWAYS use this as source of truth)
            $currentClass = DB::table('elearning_classes')
                ->where('class_id', $classId)
                ->first();

            if (!$currentClass) {
                throw new \Exception('Class not found');
            }

            // Get current version from database
            $currentMajor = $currentClass->version_major ?? 1;
            $currentMinor = $currentClass->version_minor ?? 0;

            // Calculate new version based on current database version
            $newMajor = $currentMajor;
            $newMinor = $currentMinor;

            if ($versionType == 'major') {
                // Major: increment major, reset minor to 0
                $newMajor = $currentMajor + 1;
                $newMinor = 0;
            } elseif ($versionType == 'minor') {
                // Minor: increment minor only
                $newMinor = $currentMinor + 1;
            }
            // For 'none' type, keep same version numbers

            // Only archive version if it's a version update (major/minor) AND it's different from current
            if ($versionType != 'none') {
                // Archive current version to versions table
                DB::table('elearning_classes_versions')->insert([
                    'original_class_id' => $classId,
                    'class_name' => $currentClass->class_name,
                    'class_format' => $currentClass->class_format,
                    'class_description' => $currentClass->class_description,
                    'resource_name' => $currentClass->resource_name,
                    'resource_path' => $currentClass->resource_path,
                    'class_duration' => $currentClass->class_duration,
                    'class_quiz' => $currentClass->class_quiz,
                    'quiz_id' => $currentClass->quiz_id,
                    'version_major' => $currentMajor,
                    'version_minor' => $currentMinor,
                    'is_active' => 0,
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW(),
                    'updated_at' => NOW()
                ]);
            }
        //  $this->WriteFileLog($inputArray);
            // Prepare update data
            $updateData = [
                'class_name' => $inputArray['class_name'],
                // 'class_format' => $inputArray['class_format'],
                'class_description' => $inputArray['class_description'],
                'class_duration' => $inputArray['class_duration'],
                'class_quiz' => $inputArray['class_quiz'],
                'quiz_id' => $inputArray['quiz_id'],
                'version_major' => $newMajor,
                'version_minor' => $newMinor,
                'is_active' => 1,
                'updated_by' => auth()->user()->id,
                'updated_at' => NOW()
            ];

            // Handle resource file
            if (isset($inputArray['resource_name']) && $inputArray['resource_name'] != '0') {
                $updateData['resource_name'] = $inputArray['resource_name'];
                $updateData['resource_path'] = $inputArray['resourse_path'] ?? $currentClass->resource_path;
            }

            // Update the class
            $update_id = DB::table('elearning_classes')
                ->where('class_id', $classId)
                ->update($updateData);

            if (!$update_id) {
                DB::rollBack();
                throw new \Exception('Failed to update class');
            }



            // Commit transaction
            DB::commit();

            // Prepare success message based on update type
            if ($versionType != 'none') {
                $message = "Class Updated Successfully from v{$currentMajor}.{$currentMinor} to v{$newMajor}.{$newMinor}";
                $notificationMessage = "Class Updated Successfully to v{$newMajor}.{$newMinor}";
                $auditDescription = "Class Updation from v{$currentMajor}.{$currentMinor} to v{$newMajor}.{$newMinor}";
            } else {
                $message = "Class Updated Successfully (No Version Change) - v{$currentMajor}.{$currentMinor}";
                $notificationMessage = "Class Updated Successfully (No Version Change)";
                $auditDescription = "Class Updation (No Version Change) - v{$currentMajor}.{$currentMinor}";
            }

            // Notifications and audit log
            $this->notifications_insert(null, auth()->user()->id, $notificationMessage, "/class/index");

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name ?? 'Unknown';

            $this->auditLog('elearning_classes', $classId, 'Update', $auditDescription, auth()->user()->id, NOW(), $role_name_fetch);

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = $message;
            $serviceResponse['Data'] = [
                'old_version' => "{$currentMajor}.{$currentMinor}",
                'new_version' => "{$newMajor}.{$newMinor}",
                'version_type' => $versionType
            ];
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);

            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            DB::rollBack();

            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse['ExceptionLine'] = $exc->getLine();
            $exceptionResponse['ExceptionFile'] = $exc->getFile();
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

    public function get_class_versions(Request $request)
    {
        try {
            $method = 'Method => tryController => get_class_versions';
            $inputArray = $this->decryptData($request->requestData);
            $classId = $inputArray['class_id'];

            // Get current active version from main table
            $currentVersion = DB::table('elearning_classes')
                ->where('class_id', $classId)
                ->select(
                    'class_id as original_class_id',
                    'class_name',
                    'class_description',
                    'resource_name',
                    'resource_path',
                    'class_duration',
                    'class_quiz',
                    'quiz_id',
                    'version_major',
                    'version_minor',
                    'is_active',
                    'updated_at as created_at',
                    DB::raw('NULL as version_id'),
                    DB::raw("'' as change_notes")
                )
                ->first();

            // Get archived versions from history table
            $oldVersions = DB::table('elearning_classes_versions')
                ->where('original_class_id', $classId)
                ->where('is_active', 0)
                ->select(
                    'original_class_id',
                    'class_name',
                    'class_description',
                    'resource_name',
                    'resource_path',
                    'class_duration',
                    'class_quiz',
                    'quiz_id',
                    'version_major',
                    'version_minor',
                    'is_active',
                    'created_at',
                    'version_id',
                    DB::raw("'' as change_notes")
                )
                ->orderBy('version_major', 'desc')
                ->orderBy('version_minor', 'desc')
                ->get();

            // Combine versions and remove duplicates
            $allVersions = [];
            $versionKeys = [];

            // Add current version
            if ($currentVersion) {
                $key = $currentVersion->version_major . '.' . $currentVersion->version_minor;
                $versionKeys[$key] = true;
                $allVersions[] = $currentVersion;
            }

            // Add archived versions (skip if same version as current)
            foreach ($oldVersions as $version) {
                $key = $version->version_major . '.' . $version->version_minor;
                if (!isset($versionKeys[$key])) {
                    $versionKeys[$key] = true;
                    $allVersions[] = $version;
                }
            }



            // Sort versions again after adding change notes
            usort($allVersions, function ($a, $b) {
                if ($b->version_major != $a->version_major) {
                    return $b->version_major - $a->version_major;
                }
                return $b->version_minor - $a->version_minor;
            });

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $allVersions;
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

    public function restore_class_version(Request $request)
    {
        try {
            $method = 'Method => ElearningQuestionController => restore_class_version';
            $inputArray = $this->decryptData($request->requestData);

            $classId = $inputArray['class_id'];
            $versionId = $inputArray['version_id'];

            DB::beginTransaction();

            // Get version to restore
            $versionToRestore = DB::table('elearning_classes_versions')
                ->where('version_id', $versionId)
                ->first();

            if (!$versionToRestore) {
                throw new \Exception('Version not found');
            }

            // Get current class data
            $currentClass = DB::table('elearning_classes')
                ->where('class_id', $classId)
                ->first();

            // Archive current version
            if ($currentClass) {
                DB::table('elearning_classes_versions')->insert([
                    'original_class_id' => $classId,
                    'class_name' => $currentClass->class_name,
                    'class_format' => $currentClass->class_format,
                    'class_description' => $currentClass->class_description,
                    'resource_name' => $currentClass->resource_name,
                    'resource_path' => $currentClass->resource_path,
                    'class_duration' => $currentClass->class_duration,
                    'class_quiz' => $currentClass->class_quiz,
                    'quiz_id' => $currentClass->quiz_id,
                    'version_major' => $currentClass->version_major,
                    'version_minor' => $currentClass->version_minor,
                    'is_active' => 0,
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);
            }
           
            // Restore selected version
            DB::table('elearning_classes')
                ->where('class_id', $classId)
                ->update([
                    'class_name' => $versionToRestore->class_name,
                     'class_format' => $versionToRestore->class_format,
                    'class_description' => $versionToRestore->class_description,
                    'resource_name' => $versionToRestore->resource_name,
                    'resource_path' => $versionToRestore->resource_path,
                    'class_duration' => $versionToRestore->class_duration,
                    'class_quiz' => $versionToRestore->class_quiz,
                    'quiz_id' => $versionToRestore->quiz_id,
                    'version_major' => $versionToRestore->version_major,
                    'version_minor' => $versionToRestore->version_minor,
                    'is_active' => 1,
                    'updated_by' => auth()->user()->id,
                    'updated_at' => NOW()
                ]);

            // Mark all other versions as inactive
            DB::table('elearning_classes_versions')
                ->where('original_class_id', $classId)
                ->update(['is_active' => 0]);

            // Mark restored version as active
            DB::table('elearning_classes_versions')
                ->where('version_id', $versionId)
                ->update(['is_active' => 1]);

            DB::commit();

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = "Class restored to version {$versionToRestore->version_major}.{$versionToRestore->version_minor}";
            $serviceResponse['Data'] = 1;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            return $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
        } catch (\Exception $exc) {
            DB::rollBack();
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            return $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
        }
    }
}