<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\If_;

class GamificationLevelController extends BaseController
{



    public function store(Request $request)
    {
        try {
            $this->WriteFileLog($request);

            $method = 'Method => GaminficationLevelController => store';
            $inputArray = $request->requestData;
            $inputArray = $this->decryptData($inputArray);

            $input = [
                'level_number' => $inputArray['level_number'],
                'level_name' => $inputArray['level_name'],
                'min_point' => $inputArray['min_point'],
                'max_point' => $inputArray['max_point'],
                'level_icon' => $inputArray['level_icon'],
            ];

            $levels['number'] = DB::table('gamification_levels')
                ->where('level_number', $input['level_number'])

                ->where('active_flag', 1)
                ->exists();
            $levels['name'] = DB::table('gamification_levels')
                ->where('level_name', $input['level_name'])
                ->where('active_flag', 1)
                ->exists();

            $error_message = "";

            if ($levels['number']) {
                $error_message = 'Level Number already exists please try another number';
            } else if ($levels['name']) {
                $error_message = 'Level Name already exists  please try another name';
            }

            if (!empty($error_message)) {
                $serviceResponse = [
                    'Code' => 409,
                    'Message' => $error_message,
                    'Data' => null
                ];

                return $this->SendServiceResponse(
                    json_encode($serviceResponse, JSON_FORCE_OBJECT),
                    409,
                    false
                );
            }

            $rows = DB::table('gamification_levels')->insertGetId([
                'level_number' => $input['level_number'],
                'level_name' => $input['level_name'],
                'min_point' => $input['min_point'],
                'max_point' => $input['max_point'],
                'level_icon' => $input['level_icon'],
                'created_at' => NOW(),
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            $this->notifications_insert(null, auth()->user()->id, "Level Created Successfully", "/level_master_page");

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur 
                                 INNER JOIN users us ON (us.array_roles=ur.role_id) 
                                 WHERE us.id=" . auth()->user()->id);

            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog($input['level_name'], $rows, 'Create', 'Level Created Successfully', auth()->user()->id, NOW(), $role_name_fetch);

            $serviceResponse = [
                'Code' => config('setting.status_code.success'),
                'Message' => config('setting.status_message.success'),
                'Data' => $rows
            ];

            return $this->SendServiceResponse(json_encode($serviceResponse, JSON_FORCE_OBJECT), config('setting.status_code.success'), true);
        } catch (\Exception $exc) {
            $exceptionResponse = [
                'ServiceMethod' => $method,
                'Exception' => $exc->getMessage()
            ];
            $this->WriteFileLog(json_encode($exceptionResponse, JSON_FORCE_OBJECT));

            $serviceResponse = [
                'Code' => config('setting.status_code.exception'),
                'Message' => $exc->getMessage()
            ];
            return $this->SendServiceResponse(json_encode($serviceResponse, JSON_FORCE_OBJECT), config('setting.status_code.exception'), false);
        }
    }


    public function show(Request $request)
    {

        $method = 'Method => GamificationLevelController =>show';
        try {

            $userID = auth()->user()->level_id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'level_id' => $inputArray['level_id'],
            ];
            $level_id = $input['level_id'];

            $rows = DB::select("SELECT * FROM gamification_levels WHERE level_id = ?", [$level_id]);
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
    public function update(Request $request)
    {
        try {
            // $this->WriteFileLog($request);

            $method = 'Method => GamificationLevelController => update';
            $inputArray = $request->requestData;

            $inputArray = $this->decryptData($inputArray);
            $input = [
                'level_id' => $inputArray['level_id'],
                'level_name' => $inputArray['level_name'],
                'level_number' => $inputArray['level_number'],
                'max_point' => $inputArray['max_point'],
                'min_point' => $inputArray['min_point'],
                'level_icon' => $inputArray['level_icon'],
            ];
            $this->WriteFileLog($input);


            $level_id = $input['level_id'];

            $rows = DB::table('gamification_levels')
                ->where('level_id', $level_id)
                ->update([
                    'level_name' => $input['level_name'],
                    'level_number' => $input['level_number'],
                    'max_point' => $input['max_point'],
                    'min_point' => $input['min_point'],
                    'level_icon' => $input['level_icon'],
                ]);

            $this->notifications_insert(null, auth()->user()->id, "Level  Updated Successfully", "/level_master_page");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('Gamification Level', $rows, 'Create', 'Level  Updation', auth()->user()->id, NOW(), $role_name_fetch);

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
        $method = 'Method => GamificationLevelController => getAll';
        try {
            $allRecords['levels'] = DB::table('gamification_levels')
                ->where('active_flag', 1)
                ->orderBy('level_id', 'desc')
                ->get();

            $this->WriteFileLog($allRecords['levels']);



            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $allRecords;
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

            $method = 'Method => GamificationLevelController => delete';
            $inputArray = $request->requestData;

            $inputArray = $this->decryptData($inputArray);
            $input = [
                'level_id' => $inputArray['level_id'],
            ];


            $level_id = $input['level_id'];

            $rows = DB::table('gamification_levels')
                ->where('level_id', $level_id)
                ->update([

                    'active_flag' => 0,
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
  
}
