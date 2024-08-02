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

class webportalController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function memberlist_store(Request $request)
    {

        try {
            $method = 'Method => add memberlist => memberlist_store';
            $inputArray = $this->decryptData($request->requestData);
            $user_id = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];

            $input = [
                'name' => $inputArray['name'],
                'type' => $inputArray['type'],
                'mclass' => $inputArray['mclass'],
                'chapter' => $inputArray['chapter'],
                'isu_reg_number' => $inputArray['isu_reg_number'],
                'qualification' => $inputArray['qualification'],
                'address' => $inputArray['address'],
                'email' => $inputArray['email'],
                'phone' => $inputArray['phone'],
                'location' => $inputArray['location'],
                'gender' => $inputArray['gender'],


            ];
            DB::transaction(function () use ($input) {
                $role_id = DB::table('webportal_members')
                    ->insertGetId([
                        'name' => $input['name'],
                        'type' => $input['type'],
                        'mclass' => $input['mclass'],
                        'chapter' => $input['chapter'],
                        'isu_reg_number' => $input['isu_reg_number'],
                        'qualification' => $input['qualification'],
                        'address' => $input['address'],
                        'email' => $input['email'],
                        'phone' => $input['phone'],
                        'location' => $input['location'],
                        'gender' => $input['gender'],
                        'created_at' => NOW(),
                        'updated_at' => NOW()

                    ]);
            });

            $this->notifications_insert(null, auth()->user()->id, "Memberlist Created Successfully", "/member/store");

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

    public function member_list(Request $request)
    {
        $logMethod = 'Method => webportalController => User';
        try {
            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $rows = array();
            $rows['rows'] = DB::table('webportal_members')
                ->select('*')
                ->where('status', 1)
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
    public function member_listDrupal(Request $request)
    {
        $logMethod = 'Method => webportalController => User';
        try {
            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $rows = array();
            $rows['rows'] = DB::table('webportal_members')
                ->select('*')
                ->where('status', 1)
                ->get();
                $serviceResponse = [
                    'Success' => true,
                    'Data' => $rows,
                    'Status' => 200
                ];
                return response()->json($serviceResponse, 200);
            
            return $rows;
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
    public function member_delete(Request $request)
    {

        try {

            $method = 'Method => webportalController => member_delete';
            $inputArray = $request['requestData'];
            $userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];

            $id = $inputArray['id'];
            $uelid = DB::table('webportal_members')
                ->where('id', $id)
                ->update([
                    'status' => '0',

                ]);

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Member Details Deleted',
                'notification_url' => 'member_list',
                'megcontent' => "Member Deleted Successfully .",
                'alert_meg' => "Member details Deleted Successfully .",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('webportal_members', $userID, 'Delete', 'Admin Member Deleted Successfully', $inputArray['user_id'], NOW(), $role_name_fetch);
            $this->notifications_insert(null, auth()->user()->id, "Member Deleted Successfully", "/member_list");


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

    public function member_show(Request $request)
    {

        $method = 'Method => webportalController => member_show';
        try {

            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $id = $request->id;
            $this->WriteFileLog("fefeffe");
            $this->WriteFileLog($id);
            $row = DB::table('webportal_members')
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
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
    public function member_fetch(Request $request)
    {

       
        $method = 'Method => webportalController =>member_fetch';
        try {

            $userID = auth()->user()->id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
            ];
            $id = $input['id'];

            $rows = DB::select("SELECT  *  from webportal_members  where $id=id and status=1");
            $this->WriteFileLog($rows);
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

    public function member_edit($id)
    {
        try {
            $method = 'Method => webportalController =>edit';
            $id = $this->decryptData($id);
            $row = DB::table('webportal_members')
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
    public function member_update(Request $request)
    {
        //

        try {
            $this->WriteFileLog($request);
            $method = 'Method => webportalController => update';
            $inputArray = $this->decryptData($request->requestData);

            $input = [

                'name' => $inputArray['name'],
                'type' => $inputArray['type'],
                'mclass' => $inputArray['mclass'],
                'chapter' => $inputArray['chapter'],
                'isu_reg_number' => $inputArray['isu_reg_number'],
                'qualification' => $inputArray['qualification'],
                'address' => $inputArray['address'],
                'email' => $inputArray['email'],
                'phone' => $inputArray['phone'],
                'location' => $inputArray['location'],
                'gender' => $inputArray['gender'],
                'id' => $inputArray['id'],

            ];
            $this->WriteFileLog($input);

            DB::table('webportal_members')
                ->where('id', $input['id'])
                ->update([
                    'name' => $input['name'],
                    'type' => $input['type'],
                    'mclass' => $input['mclass'],
                    'chapter' => $input['chapter'],
                    'isu_reg_number' => $input['isu_reg_number'],
                    'qualification' => $input['qualification'],
                    'address' => $input['address'],
                    'email' => $input['email'],
                    'phone' => $input['phone'],
                    'location' => $input['location'],
                    'gender' => $input['gender'],
                    'id' => $inputArray['id'],
                    'created_at' => NOW(),
                    'updated_at' => NOW()

                ]);
            $this->notifications_insert(null, auth()->user()->id, "Member Updated Successfully", "/member_list");


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

    public function memberbulk_store(Request $request)
    {

        try {
            $method = 'Method => add memberlist => memberbulk_store';
            $inputArray = $this->decryptData($request->requestData);
            $user_id = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];

            $input = [
                'jsonData' => $inputArray['jsonData'],
            ];

            DB::transaction(function () use ($input) {
                $data = $input['jsonData'];
                // $this->WriteFileLog($data);
                // $this->WriteFileLog($data['name']);
                foreach($data as $key => $val){
                    $role_id = DB::table('webportal_members')
                    ->insertGetId([
                        'name' => (isset($val->name) ? $val->name : ''),
                        'type' => (isset($val->type) ? $val->type : ''),
                        'mclass' => (isset($val->mclass) ? $val->mclass : ''),
                        'chapter' => (isset($val->chapter) ? $val->chapter : ''),
                        'isu_reg_number' => (isset($val->isu_reg_number) ? $val->isu_reg_number : ''),
                        'qualification' => (isset($val->qualification) ? $val->qualification : ''),
                        'address' => (isset($val->address) ? $val->address : ''),
                        'email' => (isset($val->email) ? $val->email : ''),
                        'phone' => (isset($val->phone) ? $val->phone : ''),
                        'location' => (isset($val->location) ? $val->location : ''),
                        'gender' => (isset($val->gender) ? $val->gender : ''),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            });

            $this->notifications_insert(null, auth()->user()->id, "Memberlist Created Successfully", "/member_bulk/store");

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
