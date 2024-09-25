<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\Redirect;

class ElearningEventController extends BaseController
{
    public function event_store(Request $request)
    {
        $this->WriteFileLog($request);

        try {
            $method = 'Method => ElearningEventController => event_store';
            $inputArray = $request->requestData;
            $this->WriteFileLog($inputArray);
            $user_id = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];


            $input = [
                'user_category' => $inputArray['user_category'],
                'event_name' => $inputArray['event_name'],
                'event_description' => $inputArray['event_description'],
                'event_image' => $inputArray['event_image'],
                'event_date' => $inputArray['event_date'],
                'event_path' => $inputArray['event_path'],
                'event_date' => $inputArray['event_date'],

            ];

            $update_id=  DB::transaction(function () use ($input) {
                $role_id = DB::table('elearning_events')
                    ->insertGetId([
                        'user_category' => $input['user_category'],
                        'event_name' => $input['event_name'],
                        'event_description' => $input['event_description'],
                        'event_image' => $input['event_image'],
                        'event_path' => $input['event_path'],
                        'event_date' => $input['event_date'],
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()

                    ]);
            });

            $this->notifications_insert(null, auth()->user()->id, "Event Created Successfully", "/adminevent");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('Events', $update_id, 'create', 'Event Create', auth()->user()->id, NOW(), $role_name_fetch);


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 1;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($serviceResponse);
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

    public function adminevent_list(Request $request)
    {
        $logMethod = 'Method => ElearningEventController => adminevent_list';
        try {
            $this->WriteFileLog('hiife');
            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $rows = array();
            $rows = DB::select("SELECT role_id from uam_user_roles  where user_id=$userID");
            $role_id = $rows[0]->role_id;

            $rows['user_category'] = array(
                'Student' => config('setting.roles.Student'),
                'Teacher' => config('setting.roles.Teacher'),
                'All' => 0
            );
            // INNER JOIN uam_roles AS ur ON ur.role_id = et.user_category

            $rows['quiz_list'] =  DB::select("SELECT event_id,event_name,event_image,event_date,user_category from elearning_events as en  where event_status=0 ORDER BY created_at DESC");


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
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $logMethod;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($serviceResponse);

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

            $method = 'Method => ElearningEventController => event_delete';
            $inputArray = $request['requestData'];
            $userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];


            $id = $inputArray['event_id'];
            $update_id = DB::table('elearning_events')
                ->where('event_id', $id)
                ->update([
                    'event_status' => '1',

                ]);

            $this->notifications_insert(null, auth()->user()->id, "Event Deleted Successfully", "/adminevent");

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('Events', $update_id, 'Delete', 'Event Deletion', auth()->user()->id, NOW(), $role_name_fetch);

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
    public function event_show(Request $request)
    {

        $method = 'Method => ElearningEventController => event_show';
        try {

            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $id = $request->id;
            $this->WriteFileLog("fefeffe");
            $this->WriteFileLog($id);
            $row = DB::table('elearning_events')
                ->select('*')
                ->where('event_id', $id)
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
    public function event_edit($id)
    {
        try {
            $method = 'Method => ElearningEventController =>event_edit';
            $id = $this->decryptData($id);
            $row = DB::table('elearning_events')
                ->select('*')
                ->where('id', $id)
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
    public function event_update(Request $request, $id)
    {
        //

        try {
            $this->WriteFileLog($request);
            $method = 'Method => ElearningEventController => event_update';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'user_category' => $inputArray['user_category'],
                'event_name' => $inputArray['event_name'],
                'event_description' => $inputArray['event_description'],
                'event_image' => $inputArray['event_image'],
                'event_date' => $inputArray['event_date'],
                'event_path' => $inputArray['event_path'],
                'event_date' => $inputArray['event_date'],
                'eid' => $inputArray['eid'],

            ];
            $this->WriteFileLog($input);

            $update_id=DB::table('elearning_events')
                ->where('event_id', $input['eid'])
                ->update([
                    'user_category' => $input['user_category'],
                    'event_name' => $input['event_name'],
                    'event_description' => $input['event_description'],

                    'event_date' => $input['event_date'],
                    'updated_by' => auth()->user()->id,
                    'updated_at' => NOW()

                ]);
            if ($input['event_path'] != 0) {
                DB::table('elearning_events')
                    ->where('event_id', $input['eid'])
                    ->update([

                        'event_image' => $input['event_image'],
                        'event_path' => $input['event_path'],

                    ]);
            }

            $this->notifications_insert(null, auth()->user()->id, "Event Updated Successfully", "/adminevent");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('Events', $update_id, 'Update', 'Event Updation', auth()->user()->id, NOW(), $role_name_fetch);

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



    public function event_fetch(Request $request)
    {


        try {
            $method = 'Method => ElearningEventController =>fetch';
            $userID = auth()->user()->id;
            // $rows = DB::select("SELECT role_id from uam_roles  where user_id=$userID");
            // $role_id=$rows[0]->role_id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
            ];
            $id = $input['id'];
            $rows = DB::select("SELECT user_category,event_id,event_description,event_name,event_date,event_image,event_status,created_at,updated_at,CONCAT(event_path,'/',event_image) AS full_event_path from elearning_events  where event_id =  $id ");
            $rows =
                $response = [
                    'rows' => $rows,
                ];

            $this->WriteFileLog($rows);
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
