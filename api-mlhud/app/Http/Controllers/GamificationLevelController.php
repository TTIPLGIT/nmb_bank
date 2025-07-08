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
                'min_point' => $inputArray['min_points'],
                'max_point' => $inputArray['max_points'],

            ];

    

            $rows = DB::table('gamification_levels')->insertGetId([

                'level_number' => $input['level_number'],
                'level_name' => $input['level_name'],
                'min_point' => $input['min_point'],
                'max_point' => $input['max_point'],
                'created_at' => NOW()

            ]);
            $this->notifications_insert(null, auth()->user()->id, "Level Created Successfully", "/level_master_page");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog($input['level_name'], $rows, 'Create', 'Level Created Successfully', auth()->user()->id, NOW(), $role_name_fetch);


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
                ->orderBy('level_id', 'DESC')
                ->get();

            $this->WriteFileLog( $allRecords['levels'] );

            

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
}
