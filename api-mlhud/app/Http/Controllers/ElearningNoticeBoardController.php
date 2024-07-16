<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\Redirect;

class ElearningNoticeBoardController extends BaseController
{
    public function notice_store(Request $request)
    {
        

        try {
            $method = 'Method => ElearningNoticeBoardController => notice_store';
            $inputArray = $request->requestData;         
            $user_id = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];


            $input = [
                'user_category' => $inputArray['user_category'],
                'notice_name' => $inputArray['notice_name'],
                'notice_description' => $inputArray['notice_description'],
                'notice_banner' => $inputArray['notice_banner'],
                'notice_path' => $inputArray['notice_path'],
                'notice_date' => $inputArray['notice_date'],
                'notice_author' => $inputArray['notice_author'],
            ];

            $update_id = DB::transaction(function () use ($input) {
                $role_id = DB::table('elearning_noticeboard')
                    ->insertGetId([
                        'user_category' => $input['user_category'],
                        'notice_name' => $input['notice_name'],
                        'notice_description' => $input['notice_description'],
                        'notice_banner' => $input['notice_banner'],
                        'notice_path' => $input['notice_path'],
                        'notice_date' => $input['notice_date'],
                        'notice_author' => $input['notice_author'],
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()

                    ]);
            });

            $this->notifications_insert(null, auth()->user()->id, "Notice Board Created Successfully", "/adminnoticeboard");

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('Notice Board', $update_id, 'Create', 'Notice Creation', auth()->user()->id, NOW(), $role_name_fetch);

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

    public function notice_list(Request $request)
    {
        $logMethod = 'Method => ElearningNoticeBoardController => notice_list';
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

            $rows['quiz_list'] =  DB::select("SELECT notice_id,notice_name,notice_banner,notice_date,notice_author,user_category from elearning_noticeboard as en where notice_status=0");


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



    public function notice_delete(Request $request)
    {

        try {

            $method = 'Method => ElearningNoticeBoardController => notice_delete';
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

            $this->notifications_insert(null, auth()->user()->id, "Notice Board Deleted Successfully", "/adminnoticeboard");

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
    public function notice_show(Request $request)
    {

        $method = 'Method => ElearningNoticeBoardController => notice_show';
        try {

            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $id = $request->id;
            $this->WriteFileLog("fefeffe");
            $this->WriteFileLog($id);
            $row = DB::table('elearning_noticeboard')
                ->select('*')
                ->where('notice_id', $id)
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
    public function notice_edit($id)
    {
        try {
            $method = 'Method => ElearningNoticeBoardController =>edit';
            $id = $this->decryptData($id);
            $row = DB::table('elearning_noticeboard')
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
    public function notice_update(Request $request)
    {
        //

        try {
            $this->WriteFileLog($request);
            $method = 'Method => ElearningNoticeBoardController => update';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'user_category' => $inputArray['user_category'],
                'notice_name' => $inputArray['notice_name'],
                'notice_description' => $inputArray['notice_description'],
                'notice_banner' => $inputArray['notice_banner'],
                'notice_path' => $inputArray['notice_path'],
                'notice_date' => $inputArray['notice_date'],
                'notice_author' => $inputArray['notice_author'],
                'eid' => $inputArray['eid'],

            ];

            $this->WriteFileLog($input);

            $update_id= DB::table('elearning_noticeboard')
                ->where('notice_id', $input['eid'])
                ->update([
                    'user_category' => $input['user_category'],
                    'notice_name' => $input['notice_name'],
                    'notice_description' => $input['notice_description'],
                    'notice_date' => $input['notice_date'],
                    'notice_author' => $input['notice_author'],
                    'updated_by' => auth()->user()->id,
                    'updated_at' => NOW()

                ]);
            if ($input['notice_path'] != 0) {
                DB::table('elearning_noticeboard')
                    ->where('notice_id', $input['eid'])
                    ->update([
                        'notice_banner' => $input['notice_banner'],
                        'notice_path' => $input['notice_path'],

                    ]);
            }
            $this->notifications_insert(null, auth()->user()->id, "Notice Board Updated Successfully", "/adminnoticeboard");

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('Notice Board', $update_id, 'Update', 'Notice Updation', auth()->user()->id, NOW(), $role_name_fetch);

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



    public function notice_fetch(Request $request)
    {


        try {
            $method = 'Method => ElearningNoticeBoardController =>fetch';
            $userID = auth()->user()->id;
            // $rows = DB::select("SELECT role_id from uam_roles  where user_id=$userID");
            // $role_id=$rows[0]->role_id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
            ];
            $id = $input['id'];
            $rows = DB::select("SELECT user_category,notice_id,notice_description,user_category,notice_name,notice_date,notice_banner,notice_author,notice_status,created_at,updated_at,CONCAT(notice_path,'/',notice_banner) AS full_notice_path from elearning_noticeboard  where notice_id =  $id ");
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
