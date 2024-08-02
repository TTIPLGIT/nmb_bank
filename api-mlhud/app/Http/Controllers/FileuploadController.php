<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use SebastianBergmann\CodeCoverage\Driver\Selector;
use Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\licenseMail;

class FileuploadController extends BaseController

{


    /**
     * Author: Anbukani
     * Date: 04/06/2021
     * Description: Get the user token based on email and password.
     **/


    public function fileupload_index(Request $request)
    {
        $logMethod = 'Method => FileuploadController => fileupload_index';
        try {
            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];


            $rows = DB::select("SELECT * FROM file_upload_masters WHERE active_flag=0");

            $response = [
                'rows' => $rows
            ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] =  $response;
            $this->WriteFileLog($serviceResponse);
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




    public function fileupload_store(Request $request)
    {

        try {
            $logMethod = 'Method => FileuploadController => fileupload_store';
            $inputArray = $request->requestData;
            $inputArray = $this->decryptData($inputArray);

            $user_id = (auth()->check()) ? auth()->user()->id : $request['user_id'];

            $input = [
                'file_type' => $inputArray['file_type'],
                'file_size' => $inputArray['file_size'],
            ];
            DB::transaction(function () use ($input) {
                $settings_id = DB::table('file_upload_masters')
                    ->insertGetId([
                        'file_type' => $input['file_type'],
                        'file_size' => $input['file_size'],
                        'active_flag' => '0',
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
            });


            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'File Details Store',
                'notification_url' => 'file_upload',
                'megcontent' => "File Details Stored Successfully .",
                'alert_meg' => "File Details Stored Successfully .",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('file_upload_masters', '', 'Create', 'Created File Details', $user_id, NOW(), $role_name_fetch);

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 1;
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

    public function fileupload_edit(Request $request)
    {
        try {
            $method = 'Method => FileuploadController =>fileupload_edit';
            $inputArray = $request->requestData;
            $inputArray = $this->decryptData($inputArray);
            $id = $inputArray['id'];
            $row = DB::table('file_upload_masters')
                ->select('file_type', 'file_size', 'id')
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
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }



    public function fileupload_update(Request $request)
    {

        try {
            $method = 'Method => FileuploadController => fileupload_update';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'file_type' => $inputArray['file_type'],
                'file_size' => $inputArray['file_size'],
                'id' => $inputArray['id'],
            ];


            DB::table('file_upload_masters')
                ->where('id', $input['id'])
                ->update([
                    'file_type' => $input['file_type'],
                    'file_size' => $input['file_size'],
                    'updated_by' => auth()->user()->id,
                    'updated_at' => NOW()

                ]);

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'File Details Updated',
                'notification_url' => 'file_upload',
                'megcontent' => "File Details Updated Successfully .",
                'alert_meg' => "File Details Updated Successfully .",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
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





    public function fileupload_delete(Request $request)
    {
        $method = 'Method => FileuploadController => fileupload_delete';
        try {


            $inputArray = $this->decryptData($request->requestData);
            //$inputArray = $request['requestData'];
            $userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];

            $input = [
                'id' => $inputArray['id'],
            ];

            $uelid = DB::table('file_upload_masters')
                ->where('id', $input['id'])
                ->update([
                    'active_flag' => '1',
                    'deleted_at' => NOW()

                ]);


            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'CourseName Details Deleted',
                'notification_url' => '/file_upload',
                'megcontent' => "File Details Deleted Successfully .",
                'alert_meg' => "File Details Deleted Successfully .",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('file_upload_masters', $userID, 'Delete', 'File details Deleted Successfully', $inputArray['user_id'], NOW(), $role_name_fetch);


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
}
