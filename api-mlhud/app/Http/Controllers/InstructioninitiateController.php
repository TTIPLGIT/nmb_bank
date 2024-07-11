<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\If_;

class InstructioninitiateController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function storedata(Request $request)
    {
        try {
            $userID = (auth()->check()) ? auth()->user()->id : 's';
            $method = 'Method => vbpfeedbackController => storedata';
            $inputArray = $request->requestData;
            $input = [
                'stakeholder_id' => $userID,
                'instruction_name' => $inputArray['instruction_name'],
                'description' => $inputArray['description'],

            ];
            
               $instruction =  DB::table('instruction_masters')
                    ->insertGetId([
                        'stakeholder_id' => $input['stakeholder_id'],
                        'instruction_name' => $input['instruction_name'],
                        'description' => $input['description'],
                        'active_flag' =>'0',
                        'created_at' => NOW(),
                        'created_by' =>auth()->user()->id,

                    ]);
            $response = [
                'instruction' => $instruction,

            ];

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Instruction created Successfully',
                'notification_url' => 'instruction',
                'megcontent' => "Instruction created Successfully.",
                'alert_meg' => "Instruction created Successfully.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);
            
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
					$role_name_fetch = $role_name[0]->role_name;
					$this->auditLog('vpb_create', $instruction, 'Create', 'Create new Instruction', $input['stakeholder_id'], NOW(), $role_name_fetch);

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

    public function data_edit(Request $request)
    {
        try {
            $method = 'Method => UamModulesController => data_edit';
            $id = $request->requestData['id'];
            
            $rows2 = DB::select("SELECT * from instruction_masters WHERE instruction_id=$id");
           
        
            $response = [
                'rows2' => $rows2
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

    public function index_data(Request $request)
    {
        $logMethod = 'Method => vbpfeedbackController => index';
        try {
            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $role = DB::select("select role_id from uam_user_roles where user_id=$userID");
            $role = $role[0]->role_id;
            $rows = DB::select("SELECT * FROM instruction_masters WHERE stakeholder_id=$userID");
            $response = [
                'instruction' => $rows,

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
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }

    
}
