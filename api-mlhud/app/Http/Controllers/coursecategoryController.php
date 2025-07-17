<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\If_;

class coursecategoryController extends BaseController
{

    public function index(Request $request)
    {

        $method = 'Method => coursecategoryController => index';

        $input = [
            'catagory_name' => $request['catagory_name'],
            'sub_catagory' =>  $request['sub_catagory'],
            'description' => $request['description']

        ];

        $response = DB::transaction(function () use ($input) {
            return DB::table('course_catagory')->insertGetId([
                'catagory_name' => $input['catagory_name'],
                'sub_catagory' => $input['sub_catagory'],
                'description' => $input['description'],
                'created_by' => auth()->user()->id,
                'created_at' => now(),
            ]);
        });
    }

    public function store(Request $request)
    {
        try {
            $this->WriteFileLog($request);

            $method = 'Method => coursecategoryController => store';
            $inputArray = $request->requestData;

            $inputArray = $this->decryptData($inputArray);
            $input = [

                'catagory_name' => $inputArray['catagory_name'],
                'sub_catagory' => $inputArray['sub_catagory'],
                'description' => $inputArray['description'],
                'badge' => $inputArray['badge'],
                'badge_name' => $inputArray['badge_name'],
                'badge_count' => $inputArray['badge_count'],
                'badge_icon' => $inputArray['badge_icon'],
                'streak_challenge' => $inputArray['streak_challenge'],
                'streak_name' => $inputArray['streak_name'],
                'number_course_for_streak' => $inputArray['number_course_for_streak'],
                'bonus_point' => $inputArray['bonus_point'],
                'complete_within' => $inputArray['complete_within'],
                'complete_within_type' => $inputArray['complete_within_type'],
                'streak_icon' => $inputArray['streak_icon'],
                'course_locked' => $inputArray['course_locked'],
                'points_to_unlock' => $inputArray['points_to_unlock'],


            ];


            $rows = DB::table('course_catagory')->insertGetId([

                'catagory_name' => $input['catagory_name'],
                'sub_catagory' => $input['sub_catagory'],
                'description' => $input['description'],
                'badge' => $input['badge'],
                'badge_name' => $input['badge_name'],
                'badge_count' => $input['badge_count'],
                'badge_icon' => $input['badge_icon'],
                'streak_challenge' => $input['streak_challenge'],
                'streak_name' => $input['streak_name'],
                'number_course_for_streak' => $input['number_course_for_streak'],
                'bonus_point' => $input['bonus_point'],
                'complete_within' => $input['complete_within'],
                'complete_within_type' => $input['complete_within_type'],
                'streak_icon' => $input['streak_icon'],
                'course_locked' => $input['course_locked'],
                'points_to_unlock' => $input['points_to_unlock'],
                'created_by' => auth()->user()->id,
                'created_at' => NOW()

            ]);
            $this->notifications_insert(null, auth()->user()->id, "Course Category Created Successfully", "/catagory_list");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog($input['catagory_name'], $rows, 'Create', 'Catagory Created Successfully', auth()->user()->id, NOW(), $role_name_fetch);


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $rows;
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

    public function update(Request $request)
    {
        try {


            $method = 'Method => coursecategoryController => update';
            $inputArray = $request->requestData;

            $inputArray = $this->decryptData($inputArray);


            $input = [

                'catagory_name' => $inputArray['catagory_name'],
                'sub_catagory' => $inputArray['sub_catagory'],
                'description' => $inputArray['description'],
                'catagory_id' => $inputArray['catagory_id'],
                'badge' => $inputArray['badge'],
                'badge_name' => $inputArray['badge_name'],
                'badge_count' => $inputArray['badge_count'],
                'badge_icon' => $inputArray['badge_icon'],
                'streak_challenge' => $inputArray['streak_challenge'],
                'streak_name' => $inputArray['streak_name'],
                'number_course_for_streak' => $inputArray['number_course_for_streak'],
                'bonus_point' => $inputArray['bonus_point'],
                'complete_within' => $inputArray['complete_within'],
                'complete_within_type' => $inputArray['complete_within_type'],
                'streak_icon' => $inputArray['streak_icon'],
                'course_locked' => $inputArray['course_locked'],
                'points_to_unlock' =>  $inputArray['points_to_unlock'],

            ];
            if ($input['badge'] == 0) {
                $input['badge_name'] = null;
                $input['badge_count'] = null;
                $input['badge_icon'] = null;
            }
             if ($input['streak_challenge'] == 0) {
                $input['number_course_for_streak'] = null;
                $input['bonus_point'] = null;
                $input['streak_name'] = null;
                $input['complete_within'] = null;
                $input['complete_within_type'] = null;
                $input['streak_icon'] = null;
                $input['points_to_unlock'] = null;
            }
             if ($input['course_locked'] == 0) {
                $input['points_to_unlock'] = null;
          
             
            }
            $this->WriteFileLog($input);


            $catagory_id = $input['catagory_id'];

            $rows = DB::table('course_catagory')
                ->where('catagory_id', $catagory_id)
                ->update([
                    'catagory_name'             => $input['catagory_name'],
                    'sub_catagory'              => $input['sub_catagory'],
                    'description'               => $input['description'],
                    'badge'                     => $input['badge'],
                    'badge_name'                => $input['badge_name'],
                    'badge_count'               => $input['badge_count'],
                    'badge_icon'                => $input['badge_icon'],
                    'streak_challenge'          => $input['streak_challenge'],
                    'streak_name'               => $input['streak_name'],
                    'number_course_for_streak'  => $input['number_course_for_streak'],
                    'bonus_point'               => $input['bonus_point'],
                    'complete_within'           => $input['complete_within'],
                    'complete_within_type'      => $input['complete_within_type'],
                    'streak_icon'               => $input['streak_icon'],
                    'course_locked'             => $input['course_locked'],
                    'points_to_unlock'          => $input['points_to_unlock'],
                ]);



            $this->notifications_insert(null, auth()->user()->id, "Course Category  Updated Successfully", "/catagory_list");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('Course Category', $rows, 'Create', 'Catagory Updation', auth()->user()->id, NOW(), $role_name_fetch);

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $rows;
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

    public function delete(Request $request)
    {
        try {
            $this->WriteFileLog($request);

            $method = 'Method => coursecategoryController => delete';
            $inputArray = $request->requestData;

            $inputArray = $this->decryptData($inputArray);
            $input = [
                'catagory_id' => $inputArray['catagory_id'],
            ];


            $catagory_id = $input['catagory_id'];

            $rows = DB::table('course_catagory')
                ->where('catagory_id', $catagory_id)
                ->update([

                    'active_flag' => 1,
                ]);



            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $rows;
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
    public function getAll(Request $request)
    {
        try {
            $allRecords['categories'] = DB::table('course_catagory')
                ->where('active_flag', 0)
                ->orderBy('catagory_id', 'DESC')
                ->get();

            $this->WriteFileLog($allRecords['categories']);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $allRecords;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function course_catagory_fetch(Request $request)
    {

        $method = 'Method => coursecategoryController =>course_catagory_fetch';
        try {

            $userID = auth()->user()->catagory_id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'catagory_id' => $inputArray['catagory_id'],
            ];
            $catagory_id = $input['catagory_id'];

            $rows = DB::select("SELECT * FROM course_catagory WHERE catagory_id = ?", [$catagory_id]);
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
}
