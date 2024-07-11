<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\If_;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\Mail;
use App\Mail\feedbackMail;
use App\Mail\valuerrejectmail;
use App\Mail\WaitingapprovalMail;
use App\Mail\taskassignMail;
use App\Mail\firmtaskassignMail;
use App\Mail\taskacceptedMail;
use App\Mail\stackholderacceptMail;
use App\Mail\registrarfeedbackMail;

class vbpfeedbackController extends BaseController
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)

    {

        $logMethod = 'Method => vbpfeedbackController => index';
        try {
            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            if ($userID == null) {
                $error_code = 404;
                return $error_code;
            }
            $role = DB::select("select role_id from uam_user_roles where user_id=$userID");
            $role = $role[0]->role_id;
            $rows = DB::select("SELECT * FROM instruction_masters WHERE stakeholder_id=$userID and active_flag='0'");
            $listview = DB::select("SELECT COUNT(*) AS total, a.id, a.stakeholder_id, a.task_name, a.type, 
            CASE WHEN a.firm_id IS NOT NULL THEN f.firm_name ELSE b.name END AS name, 
            a.status, a.cgv_approval, a.stakeholder_comment 
           FROM instruction_details AS a  
           LEFT JOIN users AS b ON (a.firm_id IS NULL AND a.valuer_id = b.id) OR (a.firm_id IS NOT NULL AND a.firm_id = b.id) 
           LEFT JOIN firm_registration AS f ON a.firm_id = f.user_id 
           WHERE a.stakeholder_id = $userID 
           GROUP BY a.valuer_id, a.stakeholder_id, a.task_name, a.status, a.id, a.cgv_approval, name, firm_name;
     ");

            $response = [
                'instruction' => $rows,
                'listview' => $listview,
                'role' => $role

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

    public function create()
    {
        $logMethod = 'Method => vbpfeedbackController => create';

        try {
            $userID = (auth()->check()) ? auth()->user()->id : 's';

            $role = DB::select("SELECT role_id FROM uam_user_roles WHERE user_id=$userID");
            $role = $role[0]->role_id;
            $rows = DB::select("SELECT * FROM instruction_masters WHERE stakeholder_id=$userID and active_flag='0'");
            $data = DB::select("SELECT users.* from users inner join uam_user_roles on users.id=user_id INNER JOIN professional_member_licence AS pl ON pl.user_id = users.id  where role_id='34' and pl.valuer_type = 'Private Valuer';");
            $cgv_users = $this->GetUserOnDesignation('CGV');
            $data2 = DB::select("SELECT * FROM firm_registration WHERE status='1'");
            $response = [
                'instruction' => $rows,
                'valuer' => $data,
                'firm' => $data2,
                'cgv_users' => $cgv_users
            ];






            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('instruction_details', $userID, 'instruction assigned', 'Task Assigned Successfully', auth()->user()->id, NOW(), $role_name_fetch);


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
            //return $this->SuccessResponse($rows);
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
                    'active_flag' => '0',
                    'created_at' => NOW(),
                    'created_by' => auth()->user()->id,

                ]);
            $response = [
                'instruction' => $instruction,

            ];

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Instruction created Successfully',
                'notification_url' => '/initiation/create',
                'megcontent' => "Instruction created Successfully.",
                'alert_meg' =>  "Instruction created Successfully.",
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
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }

    public function updatedata(Request $request)
    {

        try {
            $method = 'Method => UamModulesController => updatedata';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'instruction_id' => $inputArray['instruction_id'],
                'instruction_name' => $inputArray['instruction_name'],
                'description' => $inputArray['description'],

            ];

            DB::table('instruction_masters')
                ->where('instruction_id', $input['instruction_id'])
                ->update([
                    'instruction_name' => $input['instruction_name'],
                    'description' => $input['description'],
                    'updated_by' => auth()->user()->id,
                    'updated_at' => NOW()

                ]);

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'instruction Updated',
                'notification_url' => '/initiation/create',
                'megcontent' => "instruction " . $input['instruction_name'] . " Updated Successfully .",
                'alert_meg' => "description " . $input['description'] . " Updated Successfully .",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            //   $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
            //       INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

            //   $role_name_fetch=$role_name[0]->role_name;

            //  $role_name=DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);
            //  $role_name_fetch=$role_name[0]->role_name;
            //  $this->auditLog('uam_modules', $input['module_id'] , 'Update', 'Update uam module', auth()->user()->id, NOW(),$role_name_fetch);


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

    public function delete($id)
    {
        try {
            $method = 'Method =>AreasMasterController => delete';
            $id = $this->decryptData($id);
            $check = DB::select("SELECT * FROM instruction_masters WHERE instruction_id =$id AND active_flag='0'");

            if ($check != []) {


                DB::table('instruction_masters')
                    ->where('instruction_id', $id)
                    ->update([
                        'active_flag' => 1,
                    ]);

                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.success');
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 1;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                return $sendServiceResponse;
            } else {

                $serviceResponse = array();
                $serviceResponse['Code'] = 400;
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 1;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                return $sendServiceResponse;
            }
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
    public function index_data(Request $request)
    {
        $logMethod = 'Method => vbpfeedbackController => index';
        try {
            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            // get in role_id
            $role = DB::select("select role_id from uam_user_roles where user_id=$userID");
            $role = $role[0]->role_id;
            $this->WriteFileLog($role);

            // get in roles_name
            $role_name = DB::select("select role_name from uam_roles WHERE role_id = $role");
            $role_name = $role_name[0]->role_name;
            // For only professional member
            if ($role_name != 'Guest Role') {
                $rows = DB::select("SELECT COUNT(*) AS total ,task_name,type, valuer_id,inst_description,stakeholder_id,a.status,a.stakeholder_comment,a.valuer_comment,name
            FROM instruction_details AS a 
            INNER JOIN users AS b ON a.valuer_id=b.id  WHERE valuer_id='$userID' and a.status !=4
            GROUP BY valuer_id, stakeholder_id,task_name,type,inst_description,stakeholder_comment,valuer_comment,status
            order by task_name desc");
            }
            // for only guest   
            else {
                $rows = DB::select("SELECT COUNT(*) AS total,SUM(CASE WHEN a.valuer_id = '$userID' THEN 1 ELSE 0 END) AS instruction_count, task_name, type, firm_id, inst_description, stakeholder_id, a.status, a.stakeholder_comment, a.valuer_comment, a.cgv_approval
                FROM instruction_details AS a 
                INNER JOIN users AS b ON a.valuer_id=b.id  
                WHERE firm_id='$userID' AND type='2'  and NOT  a.status='4' GROUP BY firm_id, stakeholder_id, task_name, type, inst_description, stakeholder_comment, valuer_comment, status, cgv_approval ORDER BY task_name DESC, status ASC");
            }
            $response = [
                'rows' => $rows,
                'role_name' => $role_name
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



    public function instruction_reject_storedata(Request $request)
    {
        try {
            $userID = (auth()->check()) ? auth()->user()->id : 's';
            $method = 'Method => vbpfeedbackController => instruction_reject_storedata';
            $inputArray = $request->requestData;
            $input = [
                'stakeholder_id' => $userID,
                'totalid' => $inputArray['totalid'],
                'task_name' => $inputArray['task_name'],
                'valuer_name' => $inputArray['valuer_name'],
                'description' => $inputArray['description'],
                'previous_element' => $inputArray['previous_element'],
                'type' => $inputArray['type'],

            ];
            $v_id = $input['previous_element'];
            $prevoius_count = DB::select("SELECT COUNT(*) AS previous_id from instruction_details
            WHERE stakeholder_id=$userID AND valuer_id =$v_id");
            for ($i = 0; $i < $prevoius_count[0]->previous_id; $i++) {
                DB::table('instruction_details')
                    ->where('stakeholder_id', '=', $userID)
                    ->where('valuer_id', '=', $v_id)
                    ->delete();
            }

            $totalid = $input['totalid'];
            foreach ($totalid as $key => $row) {
                $instruction =  DB::table('instruction_details')
                    ->insertGetId([
                        'task_name' => $input['task_name'],
                        'valuer_id' => $input['valuer_name'],
                        'stakeholder_id' => $input['stakeholder_id'],
                        'insruction_id' => $row['instruction_id'],
                        'inst_description' => $input['description'],
                        'type' => $input['type'],
                        'status' => '0',
                        'created_at' => NOW(),
                        'created_by' => auth()->user()->id,

                    ]);
            }


            $response = [
                'instruction' => $instruction,

            ];

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Instruction initated Successfully',
                'notification_url' => 'instruction',
                'megcontent' => "Instruction initiated Successfully.",
                'alert_meg' => "Instruction initiated Successfully.",
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

    public function create_data(Request $request, $id)
    {
        $logMethod = 'Method => vbpfeedbackController => create';

        try {
            $inputArray = $request->requestData;
            $userID = (auth()->check()) ? auth()->user()->id : 's';
            if ($userID == null) {
                $error_code = 404;
                return $error_code;
            }

            $role = DB::select("select role_id from uam_user_roles where user_id=$userID");
            $role = $role[0]->role_id;
            $instruction = DB::select("SELECT * FROM instruction_details AS ID
            INNER JOIN instruction_masters AS IM ON 
             ID.insruction_id=IM.instruction_id
              where ID.valuer_id =$userID AND  ID.stakeholder_id=$id");

            $response = [
                'instruction' => $instruction,

            ];


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
            //return $this->SuccessResponse($rows);
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

    public function approve_storedata(Request $request)
    {
        try {
            $userID = (auth()->check()) ? auth()->user()->id : 's';
            $method = 'Method => vbpfeedbackController => approve_storedata';
            $inputArray = $request->requestData;

            $instruction =  DB::table('instruction_details')
                ->where('valuer_id', $userID)
                ->update([

                    'status' => '1',
                    'updated_at' => NOW(),
                    'created_by' => auth()->user()->id,

                ]);

            $response = [
                'instruction' => $instruction,

            ];

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Instruction Approved Successfully',
                'notification_url' => '/Instruction/Process',
                'megcontent' => "Instruction Accepted Successfully.",
                'alert_meg' => "Instruction Accepted Successfully.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);




            $email = $this->getusermail($userID);
            $name = $this->getusername($userID);
            $base_url = config('setting.base_url');

            $data = array(
                'name' => $name,
                'email' => $email,
                'base_url' => $base_url
            );


            Mail::to($data['email'])->send(new taskacceptedMail($data));




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

    public function reject_storedata(Request $request)
    {
        try {
            $userID = (auth()->check()) ? auth()->user()->id : 's';
            $method = 'Method => vbpfeedbackController => reject_storedata';
            $role = DB::select("select role_id from uam_user_roles where user_id=$userID");
            $role = $role[0]->role_id;
            $inputArray = $request->requestData;
            $input = [
                'id' => $inputArray['id'],
                'action' => $inputArray['action']

            ];
            if ($input['action'] == 'valuer') {
                $instruction =  DB::table('instruction_details')
                    ->where('valuer_id', $userID)
                    ->where('stakeholder_id', $input['id'])
                    ->update([

                        'status' => '4',
                        'updated_at' => NOW(),
                        'created_by' => auth()->user()->id,

                    ]);
            } else if ($input['action'] == 'stakeholder') {
                $instruction =  DB::table('instruction_details')
                    ->where('stakeholder_id', $userID)
                    ->where('valuer_id', $input['id'])
                    ->update([
                        'status' => '4',
                        'updated_at' => NOW(),
                        'created_by' => auth()->user()->id,
                    ]);
            } else {
                $instruction =  DB::table('instruction_details')
                    ->where('firm_id', $userID)
                    ->where('valuer_id', $input['id'])
                    ->update([
                        'status' => '4',
                        'updated_at' => NOW(),
                        'created_by' => auth()->user()->id,
                    ]);
            }

            $response = [
                'instruction' => $instruction,

            ];
            $stakeholder_id = $input['id'];


            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Instruction rejected Successfully',
                'notification_url' => 'initiation',
                'megcontent' => "Instruction rejected Successfully.",
                'alert_meg' => "Instruction rejected Successfully.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => $stakeholder_id,
                'notification_status' => 'Instruction rejected Successfully',
                'notification_url' => 'initiation',
                'megcontent' => "Valuer Rejected the Task Successfully.",
                'alert_meg' => "Valuer Rejected the Task Successfully.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW(),
            ]);

            $email = $this->getusermail($stakeholder_id);
            $name = $this->getusername($stakeholder_id);
            $base_url = config('setting.base_url');

            $data = array(
                'name' => $name,
                'email' => $email,
                'base_url' => $base_url
            );

            Mail::to($data['email'])->send(new valuerrejectmail($data));



            // $this->auditLog('vpb_create', $instruction, 'Create', 'Create new Instruction', $input['stakeholder_id'], NOW(), $role_name_fetch);

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

    public function stakeholder_reject_storedata(Request $request)
    {
        try {
            $userID = (auth()->check()) ? auth()->user()->id : 's';
            $method = 'Method => vbpfeedbackController => stakeholder_reject_storedata';
            $inputArray = $request->requestData;
            $input = [
                'valuer_id' => $inputArray['valuer_id'],
                'stakeholder_id' => $inputArray['stakeholder_id'],
                'cgv_comment' => $inputArray['cgv_comment']
            ];

            $instruction =  DB::table('instruction_details')
                ->where('valuer_id', $input['valuer_id'])
                ->where('stakeholder_id', $input['stakeholder_id'])
                ->update([

                    'cgv_approval' => '3',
                    'cgv_comment' => $input['cgv_comment'],
                    'status' => '0',
                    'updated_at' => NOW(),
                    'created_by' => auth()->user()->id,

                ]);
            $task_delete = DB::select("SELECT count(*) AS previous_id,task_id,b.id FROM instruction_process AS a 
                INNER JOIN instruction_details AS b ON 
                 a.task_id =b.id group by task_id,b.id");
            $task_id = $task_delete[0]->task_id;
            for ($i = 0; $i < $task_delete[0]->previous_id; $i++) {
                DB::table('instruction_process')
                    ->where('task_id', '=', $task_id)
                    ->delete();
            }
            $response = [
                'instruction' => $instruction,

            ];

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Instruction rejected Successfully',
                'notification_url' => 'instruction',
                'megcontent' => "Instruction rejected Successfully.",
                'alert_meg' => "Instruction rejected Successfully.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);



            // $this->auditLog('vpb_create', $instruction, 'Create', 'Create new Instruction', $input['stakeholder_id'], NOW(), $role_name_fetch);

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

    public function edit_storedata(Request $request)
    {
        try {
            $userID = (auth()->check()) ? auth()->user()->id : 'user_id';
            $role = DB::select("select role_id from uam_user_roles where user_id=$userID");
            $role = $role[0]->role_id;
            $method = 'Method => vbpfeedbackController => edit_storedata';
            $inputArray = $request->requestData;
            $this->WriteFileLog($inputArray);

            $input = [
                'task_id' => $inputArray['task_id'],
                'instruction_id' => $inputArray['instruction_id'],
                'file_path' => $inputArray['file_path'],
                'valuer_comments' => $inputArray['valuer_comments'],
                'file' => $inputArray['instruction_file'],
                'action' => $inputArray['action'],
                'stakeholder_id' => $inputArray['stakeholder_id']

            ];
            $rows = $input['file'];

            if ($input['action'] == 'cgv_approval') {
                foreach ($rows as $key => $row) {
                    $instruction =  DB::table('instruction_process')
                        ->insertGetId([
                            'task_id' => $input['task_id'],
                            'instruction_id' => $input['instruction_id'],
                            'valuer_comments' => $input['valuer_comments'],
                            'file_name' => $row,
                            'file_path' => $input['file_path'],
                            'status' => '0',
                            'created_at' => NOW(),
                            'created_by' => auth()->user()->id,

                        ]);
                }
                $status_update =  DB::table('instruction_details')
                    ->where('insruction_id', $input['instruction_id'])
                    ->update([
                        'status' => '2',
                        'cgv_approval' => '1'


                    ]);
            } else {
                foreach ($rows as $key => $row) {
                    $instruction =  DB::table('instruction_process')
                        ->insertGetId([
                            'task_id' => $input['task_id'],
                            'instruction_id' => $input['instruction_id'],
                            'valuer_comments' => $input['valuer_comments'],
                            'file_name' => $row,
                            'file_path' => $input['file_path'],
                            'status' => '0',
                            'created_at' => NOW(),
                            'created_by' => auth()->user()->id,

                        ]);
                }
                $status_update =  DB::table('instruction_details')
                    ->where('insruction_id', $input['instruction_id'])
                    ->update([
                        'status' => '2',


                    ]);
            }


            $response = [
                'instruction' => $instruction,
                'status_update' => $status_update,

            ];

            $stake_id = $inputArray['stakeholder_id'];

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Instruction initated Successfully',
                'notification_url' => 'instruction',
                'megcontent' => "Task Completed Successfully.",
                'alert_meg' => "Task Completed Successfully.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => $stake_id,
                'notification_status' => 'Instruction initated Successfully',
                'notification_url' => 'initiation',
                'megcontent' => "Valuer Completed your task and waiting for your approval.",
                'alert_meg' => "Valuer Completed your task and waiting for your approval.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);



            $email = $this->getusermail($stake_id);
            $name = $this->getusername($stake_id);
            $base_url = config('setting.base_url');

            $data = array(
                'name' => $name,
                'email' => $email,
                'base_url' => $base_url
            );



            Mail::to($data['email'])->send(new WaitingapprovalMail($data));



            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('instruction_details', $instruction, 'Edit', 'valuer Task Completed', $input['stakeholder_id'], NOW(), $role_name_fetch);

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

    public function data_show(Request $request)
    {
        try {

            $method = 'Method => vbpfeedbackController => data_show';
            $inputArray = $request->requestData;
            $userID = $inputArray['id'];
            $initiation_id = $inputArray['initiation_id'];


            $show = DB::select("SELECT * FROM instruction_process AS ip
             INNER JOIN instruction_details  AS id ON
             ip.instruction_id = id.insruction_id 
             INNER JOIN instruction_masters AS im ON im.instruction_id =id.insruction_id 
             WHERE id.valuer_id=$userID and ip.instruction_id=$initiation_id");
            $data3 = DB::select("SELECT * FROM instruction_details WHERE type='1'");

            $response = [
                'show' => $show,
                'firms' => $data3

            ];

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Instruction Approved Successfully',
                'notification_url' => 'instruction',
                'megcontent' => "Instruction Approved Successfully.",
                'alert_meg' => "Instruction Approved Successfully.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);




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

    public function valuer_show($id)
    {
        try {
            $userID = (auth()->check()) ? auth()->user()->id : 'user_id';
            // $inputArray = $this->decryptData($request->requestData);
            $role = DB::select("select role_id from uam_user_roles where user_id=$userID");
            $role = $role[0]->role_id;
            $method = 'Method => vbpfeedbackController => valuer_show';
            $valuer = DB::select("Select * from instruction_details where id=$id");
            if ($valuer[0]->firm_id == null) {
                $valuer_id = $valuer[0]->valuer_id;
            } else {
                $valuer_id = $valuer[0]->firm_id;
            }


            $rows = DB::select("SELECT * from instruction_details AS a INNER JOIN instruction_masters AS b ON 
             a.stakeholder_id=b.stakeholder_id INNER JOIN users AS c ON c.id=a.valuer_id WHERE c.id=$valuer_id");
            $instruction = DB::select("SELECT * FROM instruction_details AS ID INNER JOIN instruction_masters AS IM ON 
                ID.insruction_id=IM.instruction_id where ID.valuer_id =$valuer_id OR ID.firm_id = $valuer_id ");
            if ($rows == null) {
                $rows = DB::select("SELECT * from instruction_details AS a INNER JOIN instruction_masters AS b ON 
                    a.stakeholder_id=b.stakeholder_id INNER JOIN users AS c ON c.id=a.firm_id WHERE c.id=$valuer_id");
            }
            $data2 = DB::select("SELECT * FROM firm_registration WHERE status='1'");
            // $data4 = DB::select("SELECT * FROM firm_registration inner join users on users.id = firm_registration.user_id WHERE user_id='$userID'");

            $response = [
                'rows' => $rows,
                'instruction' => $instruction,
                'role_id' => $role,
                'firms' => $data2,

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

    public function reject_edit($id)
    {
        try {
            $id = $this->decryptData($id);
            // $userID = (auth()->check()) ? auth()->user()->id : 'user_id';
            $userID = auth()->user()->id;
            $method = 'Method => vbpfeedbackController => valuer_show';
            $valuer = DB::select("Select * from instruction_details where id=$id");
            $valuer_id = $valuer[0]->valuer_id;
            $rows = DB::select("SELECT * from instruction_details AS a INNER JOIN instruction_masters AS b ON 
             a.stakeholder_id=b.stakeholder_id INNER JOIN users AS c ON c.id=a.valuer_id WHERE c.id=$valuer_id");
            $instruction = DB::select("SELECT * FROM instruction_details AS ID INNER JOIN instruction_masters AS IM ON 
               ID.insruction_id=IM.instruction_id where ID.valuer_id =$valuer_id");

            $valuer_1 = DB::select("SELECT * FROM instruction_masters WHERE stakeholder_id=$userID and active_flag='0'");
            $valuer_2 = DB::select("SELECT users.* from users inner join uam_user_roles on users.id=user_id INNER JOIN professional_member_licence AS pl ON pl.user_id = users.id  where role_id='34';");

            $firm_reject = DB::select("SELECT * FROM firm_registration WHERE status='1'");


            $response = [
                'rows' => $rows,
                'instruction' => $instruction,
                'valuer_1' => $valuer_1,
                'valuer_2' => $valuer_2,
                'firm_reject' => $firm_reject
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

    public function stakholder_approve(Request $request)
    {

        try {
            $userID = (auth()->check()) ? auth()->user()->id : 's';
            $role = DB::select("select role_id from uam_user_roles where user_id=$userID");
            $role = $role[0]->role_id;
            $method = 'Method => vbpfeedbackController => stakholder_approve';
            $inputArray = $request->requestData;
            $valuer_id = $inputArray['valuer_id'];
            $cgv = $inputArray['cgv'];


            $instruction_count = DB::Select("select count(valuer_id) As total from instruction_details where valuer_id=$valuer_id");

            $instruction_count = $instruction_count[0]->total;

            for ($i = 0; $i < $instruction_count; $i++) {
                $status_update =  DB::table('instruction_details')
                    ->where('valuer_id', $valuer_id)
                    ->update([
                        'status' => '3',
                        'cgv_approval' => $cgv
                    ]);
            }

            $response = [
                'status_update' => $status_update,

            ];

            $valuer = $inputArray['valuer_id'];

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Instruction Approved Successfully',
                'notification_url' => 'initiation',
                'megcontent' => "You Approved the Valuer Task Successfully.",
                'alert_meg' => "You Approved the Valuer Task Successfully.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);


            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => $valuer,
                'notification_status' => 'Instruction Approved Successfully',
                'notification_url' => 'instruction',
                'megcontent' => "Stakeholder Accepted Your Task Successfully.",
                'alert_meg' =>  "Stakeholder Accepted Your Task Successfully.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            $email = $this->getusermail($valuer);
            $name = $this->getusername($valuer);
            $base_url = config('setting.base_url');

            $data = array(
                'name' => $name,
                'email' => $email,
                'base_url' => $base_url
            );



            Mail::to($data['email'])->send(new stackholderacceptMail($data));


            // $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            // $role_name_fetch = $role_name[0]->role_name;
            // $this->auditLog('vpb_create', $instruction, 'Create', 'Create new Instruction', $input['stakeholder_id'], NOW(), $role_name_fetch);

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

    public function stakeholder_feedback(Request $request)
    {
        try {
            $userID = (auth()->check()) ? auth()->user()->id : 's';
            $method = 'Method => vbpfeedbackController => stakholder_approve';
            $inputArray = $request->requestData;
            $input = [
                'stakeholder_feedback' => $inputArray['stakeholder_feedback'],
                'valuer_id' => $inputArray['valuer_id'],
            ];
            $valuer_id = $input['valuer_id'];
            $instruction_count = DB::Select("select count(valuer_id) As total from instruction_details where valuer_id=$valuer_id");

            $instruction_count = $instruction_count[0]->total;
            $current_datetime = date('Y-m-d H:i:s');
            $stakeholder_comment = $input['stakeholder_feedback'] . "'" . $current_datetime;
            for ($i = 0; $i < $instruction_count; $i++) {

                $status_update =  DB::table('instruction_details')
                    ->where('valuer_id', $input['valuer_id'])
                    ->where('stakeholder_id', $userID)
                    ->update([

                        'stakeholder_comment' => $stakeholder_comment,
                        'updated_at' => Now()

                    ]);
            }


            $response = [
                'status_update' => $status_update,

            ];

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Stakeholder submit feedback Successfully',
                'notification_url' => 'initiation',
                'megcontent' => "Stakeholder submit feedback Successfully.",
                'alert_meg' =>  "Stakeholder submit feedback Successfully.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);


            // $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            // $role_name_fetch = $role_name[0]->role_name;
            // $this->auditLog('vpb_create', $instruction, 'Create', 'Create new Instruction', $input['stakeholder_id'], NOW(), $role_name_fetch);


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

    public function valuer_feedback(Request $request)
    {
        try {
            $userID = (auth()->check()) ? auth()->user()->id : 's';
            $method = 'Method => vbpfeedbackController => stakholder_approve';
            $role = DB::select("select role_id from uam_user_roles where user_id=$userID");
            $role = $role[0]->role_id;
            $inputArray = $request->requestData;
            $input = [
                'valuer_feedback' => $inputArray['valuer_feedback'],
                'valuer_id' => $inputArray['valuer_id'],
            ];
            $valuer_id = $input['valuer_id'];

            $instruction_count = DB::Select("select count(valuer_id) As total from instruction_details where valuer_id=$valuer_id");

            $instruction_count = $instruction_count[0]->total;
            $current_datetime = date('Y-m-d H:i:s');
            $valuer_comment = $input['valuer_feedback'] . "'" . $current_datetime;
            for ($i = 0; $i < $instruction_count; $i++) {

                $status_update =  DB::table('instruction_details')
                    ->where('valuer_id', $input['valuer_id'])
                    ->update([

                        'valuer_comment' => $valuer_comment

                    ]);
            }
            $response = [
                'status_update' => $status_update,

            ];



            //   $valuer_feedback= $input['valuer_id'];

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Valuer submit feedback Successfully',
                'notification_url' => 'instruction',
                'megcontent' => "Valuer submit feedback Successfully.",
                'alert_meg' =>  "Valuer submit feedback Successfully.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            // $notifications = DB::table('notifications')->insertGetId([
            //     'user_id' => $valuer_feedback,
            //     'notification_status' => 'Valuer submit feedback Successfully',
            //     'notification_url' => '/instruction/register',
            //     'megcontent' => "Task Name()Waiting For Your Feedback.",
            //     'alert_meg' =>  "Task Name()Waiting For Your Feedback.",
            //     'created_by' => auth()->user()->id,
            //     'created_at' => NOW()
            // ]);


            // $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            // $role_name_fetch = $role_name[0]->role_name;
            // $this->auditLog('vpb_create', $instruction, 'Create', 'Create new Instruction', $input['stakeholder_id'], NOW(), $role_name_fetch);

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
    public function registar_feedback(Request $request)
    {
        try {
            $userID = (auth()->check()) ? auth()->user()->id : 's';
            $method = 'Method => vbpfeedbackController => stakholder_approve';
            $inputArray = $request->requestData;
            $input = [
                'registar_feedback' => $inputArray['registar_feedback'],
                'valuer_id' => $inputArray['valuer_id'],
            ];
            $valuer_id = $input['valuer_id'];

            $instruction_count = DB::Select("select count(valuer_id) As total from instruction_details where valuer_id=$valuer_id");

            $instruction_count = $instruction_count[0]->total;
            $current_datetime = date('Y-m-d H:i:s');
            $registar_comment = $input['registar_feedback'] . "'" . $current_datetime;
            for ($i = 0; $i < $instruction_count; $i++) {

                $status_update =  DB::table('instruction_details')
                    ->where('valuer_id', $input['valuer_id'])
                    ->update([

                        'registar_comment' => $registar_comment

                    ]);
            }
            $response = [
                'status_update' => $status_update,

            ];
            $valuer_feedback = $input['valuer_id'];


            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => ' registar submit feedback Successfully',
                'notification_url' => '/instruction/register',
                'megcontent' => "Your feedback Submitted Successfully.",
                'alert_meg' => "Your feedback Submitted Successfully.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);


            $email = $this->getusermail($valuer_feedback);
            $name = $this->getusername($valuer_feedback);
            $base_url = config('setting.base_url');

            $data = array(
                'name' => $name,
                'email' => $email,
                'base_url' => $base_url,
            );



            Mail::to($data['email'])->send(new registrarfeedbackMail($data));



            // $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            // $role_name_fetch = $role_name[0]->role_name;
            // $this->auditLog('vpb_create', $instruction, 'Create', 'Create new Instruction', $input['stakeholder_id'], NOW(), $role_name_fetch);

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

    public function registar_index(Request $request)
    {
        $logMethod = 'Method => vbpfeedbackController => index';
        try {
            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $role = DB::select("select role_id from uam_user_roles where user_id=$userID");
            $role = $role[0]->role_id;
            $rows = DB::select("SELECT * FROM instruction_masters WHERE stakeholder_id=$userID and active_flag='0'");
            $listview = DB::select("SELECT COUNT(*) AS total, a.id, a.stakeholder_id, a.task_name, name, a.status, a.stakeholder_comment, a.registar_comment
            FROM instruction_details AS a 
            INNER JOIN users AS b 
            ON a.valuer_id=b.id 
            WHERE stakeholder_comment IS NOT NULL 
            GROUP BY valuer_id, stakeholder_id, task_name, valuer_id, status, stakeholder_comment, id");
            $response = [
                'instruction' => $rows,
                'listview' => $listview,

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

    public function registar_show($id)
    {
        try {
            $userID = (auth()->check()) ? auth()->user()->id : 'user_id';

            $method = 'Method => vbpfeedbackController => valuer_show';
            $valuer = DB::select("Select * from instruction_details where id=$id");
            $valuer_id = $valuer[0]->valuer_id;
            $rows = DB::select("SELECT * from instruction_details AS a INNER JOIN instruction_masters AS b ON 
             a.stakeholder_id=b.stakeholder_id INNER JOIN users AS c ON c.id=a.valuer_id WHERE c.id=$valuer_id");
            $instruction = DB::select("SELECT * FROM instruction_details AS ID INNER JOIN instruction_masters AS IM ON 
               ID.insruction_id=IM.instruction_id where ID.valuer_id =$valuer_id");

            $response = [
                'rows' => $rows,
                'instruction' => $instruction,
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

    public function cgv_index(Request $request)
    {
        $logMethod = 'Method => vbpfeedbackController => index';
        try {
            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $role = DB::select("select role_id from uam_user_roles where user_id=$userID");
            $role = $role[0]->role_id;

            $cgv = DB::select("SELECT COUNT(*) AS total, a.id, a.stakeholder_id, a.task_name, 
            CASE WHEN a.type = 2 THEN f.firm_name ELSE b.name END AS name, 
            a.status, a.stakeholder_comment, a.cgv_approval 
            FROM instruction_details AS a 
            INNER JOIN users AS b ON a.valuer_id = b.id 
            LEFT JOIN firm_registration AS f ON a.firm_id = f.user_id AND a.type = 2 
            WHERE a.cgv_approval = 1 
            GROUP BY a.id, a.stakeholder_id, a.task_name,f.firm_name,name, a.status, a.stakeholder_comment, a.cgv_approval;");

            $response = [
                'cgv' => $cgv,
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

    public function cgv_approve($id)
    {
        try {
            $userID = (auth()->check()) ? auth()->user()->id : 'user_id';
            $method = 'Method => vbpfeedbackController => cgv_approve';
            $valuer = DB::select("Select * from instruction_details where id=$id");
            $valuer_id = $valuer[0]->valuer_id;
            $rows = DB::select("SELECT * from instruction_details AS a INNER JOIN instruction_masters AS b ON 
             a.stakeholder_id=b.stakeholder_id INNER JOIN users AS c ON c.id=a.valuer_id WHERE c.id=$valuer_id");
            $instruction = DB::select("SELECT * FROM instruction_details AS ID INNER JOIN instruction_masters AS IM ON 
               ID.insruction_id=IM.instruction_id where ID.valuer_id =$valuer_id");
            $cgv = DB::select("SELECT COUNT(*) AS total, a.id, a.stakeholder_id, a.task_name, name, a.status, a.stakeholder_comment,a.cgv_approval 
            FROM instruction_details AS a 
            INNER JOIN users AS b 
            ON a.valuer_id=b.id 
            WHERE cgv_approval='1'
            GROUP BY valuer_id, stakeholder_id, task_name, valuer_id, status, stakeholder_comment, id,cgv_approval");
            $data3 = DB::select("SELECT * FROM firm_registration WHERE status='1'");
            $response = [
                'rows' => $rows,
                'instruction' => $instruction,
                'cgv' => $cgv,
                'firms' => $data3
            ];

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'approved the valuer Successfully',
                'notification_url' => '/cgv/approve',
                'megcontent' => "Approved the Valuer Successfully.",
                'alert_meg' => "Approved the Valuer Successfully.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);



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

    public function approve_cgv(Request $request)
    {
        try {

            $userID = (auth()->check()) ? auth()->user()->id : 's';
            $method = 'Method => vbpfeedbackController => approve_cgv';
            $inputArray = $request->requestData;
            $valuer_id = $inputArray['valuer_id'];

            $instruction_count = DB::Select("select count(valuer_id) As total from instruction_details where valuer_id=$valuer_id");

            $instruction_count = $instruction_count[0]->total;

            for ($i = 0; $i < $instruction_count; $i++) {
                $status_update =  DB::table('instruction_details')
                    ->where('valuer_id', $valuer_id)
                    ->update([
                        'cgv_approval' => '2'


                    ]);
            }


            $response = [
                'status_update' => $status_update,

            ];

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => ' registar submit feedback Successfully',
                'notification_url' => '/cgv/approve',
                'megcontent' => "Approved the Valuer Successfully..",
                'alert_meg' => "Approved the Valuer Successfully..",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);



            // $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            // $role_name_fetch = $role_name[0]->role_name;
            // $this->auditLog('vpb_create', $instruction, 'Create', 'Create new Instruction', $input['stakeholder_id'], NOW(), $role_name_fetch);

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





    public function instruct_create(Request $request, $id)
    {


        $logMethod = 'Method => vbpfeedbackController => create';


        try {
            $inputArray = $request->requestData;
            $userID = (auth()->check()) ? auth()->user()->id : 'user_id';

            $partner_name = DB::select("SELECT * FROM firm_registration WHERE user_id = '$userID'");
            $partner_name_fetch = $partner_name[0]->id;

            $data2 = DB::select("SELECT * FROM firm_registration WHERE status='1'");
            $firm_partners = DB::select("SELECT * FROM firm_partners INNER JOIN users ON users.id=firm_partners.partner_id WHERE firm_id=' $partner_name_fetch' and  firm_partners.active_flag =0");
            $rows = DB::select("SELECT * FROM instruction_masters INNER JOIN instruction_details ON instruction_details.insruction_id=instruction_masters.instruction_id  where valuer_id='$userID'AND instruction_details.stakeholder_id='$id'");
            $response = [

                'firm' => $data2,
                'firm_partners' => $firm_partners,
                'instruction' => $rows

            ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
            //return $this->SuccessResponse($rows);
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



    public function firm_updatedata(Request $request)
    {

        try {
            $userID = (auth()->check()) ? auth()->user()->id : 's';
            $method = 'Method => vbpfeedbackController => update';
            $inputArray = $request->requestData;

            $input = [
                'stakeholder_id' => $inputArray['stakeholder_id'],
                'totalid' => $inputArray['totalid'],
                'task_name' => $inputArray['task_name'],
                'valuer_name' => $inputArray['valuer_name'],
                'description' => $inputArray['description'],
                'type' => $inputArray['type'],
            ];


            $totalid = $input['totalid'];
            foreach ($totalid as $key => $row) {
                $instruction =  DB::table('instruction_details')
                    ->where('firm_id', $userID)
                    ->where('insruction_id', $row['instruction_id'])
                    ->where('stakeholder_id', $input['stakeholder_id'])
                    ->update([
                        'valuer_id' => $row['partner_id'],
                        'updated_at' => NOW(),
                        'updated_by' => auth()->user()->id,

                    ]);
            }


            $response = [
                'instruction' => $instruction,
            ];

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Instruction updated Successfully',
                'notification_url' => 'instruction',
                'megcontent' => "Firm Instruction updated Successfully.",
                'alert_meg' => "Firm Instruction updated Successfully.",
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

    public function instruct_show($id)
    {
        try {
            $userID = (auth()->check()) ? auth()->user()->id : 'user_id';
            $role = DB::select("select role_id from uam_user_roles where user_id=$userID");
            $role = $role[0]->role_id;
            $method = 'Method => vbpfeedbackController => instruct_show';
            $valuer = DB::select("Select * from instruction_details where firm_id=$id");
            $valuer_id = $valuer[0]->valuer_id;
            $rows = DB::select("SELECT * from instruction_details AS a INNER JOIN instruction_masters AS b ON 
             a.stakeholder_id=b.stakeholder_id INNER JOIN users AS c ON c.id=a.valuer_id WHERE c.id=$valuer_id");
            $instruction = DB::select("SELECT * FROM instruction_details AS ID INNER JOIN instruction_masters AS IM ON 
               ID.insruction_id=IM.instruction_id where ID.firm_id =$id order BY STATUS DESC");
            $data2 = DB::select("SELECT * FROM firm_registration WHERE status='1'");
            // $data4 = DB::select("SELECT * FROM firm_registration inner join users on users.id = firm_registration.user_id WHERE user_id='$userID'");



            $response = [
                'rows' => $rows,
                'instruction' => $instruction,
                'role_id' => $role,
                'firms' => $data2,

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



    public function firm_submit(Request $request)
    {
        try {
            $userID = (auth()->check()) ? auth()->user()->id : 's';
            $method = 'Method => vbpfeedbackController => firm_submit';
            $inputArray = $request->requestData;




            $instruct_show =  DB::table('instruction_details')
                ->where('firm_id', $userID)
                ->update([

                    'status' => '5',
                    'updated_at' => NOW(),
                    'created_by' => auth()->user()->id,

                ]);

            $response = [
                'instruct_show' => $instruct_show,

            ];

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Instruction Approved Successfully',
                'notification_url' => '/Instruction/Process',
                'megcontent' => "firm Approved the Task Successfully.",
                'alert_meg' => "firm Approved the Task Successfully.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);




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

    public function firmreject_edit($id)
    {
        try {
            $id = $this->decryptData($id);
            // $userID = (auth()->check()) ? auth()->user()->id : 'user_id';
            $method = 'Method => vbpfeedbackController => firmreject_edit';
            if (!auth()->user()->id) {

                $error_code = 404;
                $serviceResponse['Code'] = config('setting.status_code.unauthenticated');
                $serviceResponse['Message'] = config('setting.status_message.unauthenticated');
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                return $sendServiceResponse;
            }
            $userID = auth()->user()->id;


            $method = 'Method => vbpfeedbackController => valuer_show';
            $valuer = DB::select("Select * from instruction_details where id=$id");

            $valuer_id = $valuer[0]->valuer_id;

            $rows = DB::select("SELECT * from instruction_details AS a INNER JOIN instruction_masters AS b ON 
             a.stakeholder_id=b.stakeholder_id INNER JOIN users AS c ON c.id=a.valuer_id WHERE c.id=$valuer_id");
            $instruction = DB::select("SELECT * FROM instruction_details AS ID INNER JOIN instruction_masters AS IM ON 
               ID.insruction_id=IM.instruction_id where ID.valuer_id =$valuer_id");

            $valuer_1 = DB::select("SELECT * FROM instruction_masters WHERE stakeholder_id=$userID and active_flag='0'");
            $valuer_2 = DB::select("SELECT * FROM users AS a INNER JOIN uam_user_roles AS b ON a.id=b.user_id
            WHERE role_id='34'");
            $data2 = DB::select("SELECT * FROM firm_registration WHERE status='1'");

            $response = [
                'rows' => $rows,
                'instruction' => $instruction,
                'valuer_1' => $valuer_1,
                'valuer_2' => $valuer_2,
                'firm' => $data2
            ];

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Instruction initated Successfully',
                'notification_url' => 'instruction',
                'megcontent' => "Firm Reject the Task Successfully.",
                'alert_meg' => "Firm Reject the Task Successfully.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);




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


    public function firm_reject_storedata(Request $request)
    {
        try {
            $userID = (auth()->check()) ? auth()->user()->id : 's';
            $method = 'Method => vbpfeedbackController => instruction_reject_storedata';
            $inputArray = $request->requestData;
            $input = [
                'stakeholder_id' => $userID,
                'totalid' => $inputArray['totalid'],
                'task_name' => $inputArray['task_name'],
                'valuer_name' => $inputArray['valuer_name'],
                'description' => $inputArray['description'],
                'process_type' => $inputArray['process_type'],
                'previous_element' => $inputArray['previous_element'],
            ];
            $v_id = $input['previous_element'];
            $prevoius_count = DB::select("SELECT COUNT(*) AS previous_id from instruction_details
            WHERE stakeholder_id=$userID AND valuer_id =$v_id");
            for ($i = 0; $i < $prevoius_count[0]->previous_id; $i++) {
                DB::table('instruction_details')
                    ->where('stakeholder_id', '=', $userID)
                    ->where('valuer_id', '=', $v_id)
                    ->delete();
            }

            $totalid = $input['totalid'];
            if ($input['process_type'] == 1) {
                foreach ($totalid as $key => $row) {
                    $instruction =  DB::table('instruction_details')
                        ->insertGetId([
                            'task_name' => $input['task_name'],
                            'valuer_id' => $input['valuer_name'],
                            'stakeholder_id' => $input['stakeholder_id'],
                            'insruction_id' => $row['instruction_id'],
                            'inst_description' => $input['description'],
                            'status' => '0',
                            'type' => '1',
                            'created_at' => NOW(),
                            'created_by' => auth()->user()->id,

                        ]);
                }
            } else {
                foreach ($totalid as $key => $row) {
                    $instruction =  DB::table('instruction_details')
                        ->insertGetId([
                            'task_name' => $input['task_name'],
                            'valuer_id' => $input['valuer_name'],
                            'stakeholder_id' => $input['stakeholder_id'],
                            'insruction_id' => $row['instruction_id'],
                            'inst_description' => $input['description'],
                            'firm_id' => $input['valuer_name'],
                            'status' => '0',
                            'type' => '2',
                            'created_at' => NOW(),
                            'created_by' => auth()->user()->id,

                        ]);
                }
            }


            $response = [
                'instruction' => $instruction,

            ];

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Instruction initated Successfully',
                'notification_url' => 'instruction',
                'megcontent' => "Firm Resend the instruction Successfully.",
                'alert_meg' => "Firm Resend the instruction Successfully.",
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
    public function Instruction_storedata(Request $request)
    {
        try {
            $userID = (auth()->check()) ? auth()->user()->id : 's';
            $role = DB::select("select role_id from uam_user_roles where user_id=$userID");
            $role = $role[0]->role_id;
            $method = 'Method => vbpfeedbackController => storedata';
            $inputArray = $request->requestData;
            $input = [
                'stakeholder_id' => $userID,
                'totalid' => $inputArray['totalid'],
                'task_name' => $inputArray['task_name'],
                'valuer_name' => $inputArray['valuer_name'],
                'description' => $inputArray['description'],
                'type' => $inputArray['type'],

            ];
            if ($input['type'] == 1) {
                $this->WriteFileLog("private");
                $totalid = $input['totalid'];
                foreach ($totalid as $key => $row) {
                    $instruction =  DB::table('instruction_details')
                        ->insertGetId([
                            'task_name' => $input['task_name'],
                            'valuer_id' => $input['valuer_name'],
                            'stakeholder_id' => $input['stakeholder_id'],
                            'insruction_id' => $row['instruction_id'],
                            'inst_description' => $input['description'],
                            'type' => $input['type'],
                            'status' => '0',
                            'created_at' => NOW(),
                            'created_by' => auth()->user()->id,

                        ]);
                }

                // valuer mail

                $valuer_id =  $input['valuer_name'];

                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => auth()->user()->id,
                    'notification_status' => 'Instruction initated Successfully',
                    'notification_url' => '/Instruction/Process',
                    'megcontent' => "Task Initiated Successfully.",
                    'alert_meg' => "Task Initiated Successfully.",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);

                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => $valuer_id,
                    'notification_status' => 'Instruction initated Successfully',
                    'notification_url' => '/Instruction/Process',
                    'megcontent' => "You have a task assigned by the stakeholder.",
                    'alert_meg' => "You have a task assigned by the stakeholder.",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);
                $email = $this->getusermail($valuer_id);
                $name = $this->getusername($valuer_id);
                $base_url = config('setting.base_url');

                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'base_url' => $base_url
                );


                Mail::to($data['email'])->send(new taskassignMail($data));
            } else {
                $this->WriteFileLog("stakeholder");

                $totalid = $input['totalid'];
                foreach ($totalid as $key => $row) {
                    $instruction =  DB::table('instruction_details')
                        ->insertGetId([
                            'task_name' => $input['task_name'],
                            'firm_id' => $input['valuer_name'],
                            'valuer_id' => $input['valuer_name'],
                            'stakeholder_id' => $input['stakeholder_id'],
                            'insruction_id' => $row['instruction_id'],
                            'inst_description' => $input['description'],
                            'type' => $input['type'],
                            'status' => '0',
                            'created_at' => NOW(),
                            'created_by' => auth()->user()->id,

                        ]);
                }
                // firm

                $firm_id =  $input['valuer_name'];

                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => auth()->user()->id,
                    'notification_status' => 'Instruction initated Successfully',
                    'notification_url' => '/Instruction/Process',
                    'megcontent' => "Task Initiated Successfully.",
                    'alert_meg' => "Task Initiated Successfully.",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);

                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => $firm_id,
                    'notification_status' => 'Instruction initated Successfully',
                    'notification_url' => '/Instruction/Process',
                    'megcontent' => "You have a task assigned by the stakeholder.",
                    'alert_meg' => "You have a task assigned by the stakeholder.",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);
            

            $email = $this->getusermail($firm_id);
            $name = $this->getusername($firm_id);
            $base_url = config('setting.base_url');

            $data = array(
                'name' => $name,
                'email' => $email,
                'base_url' => $base_url
            );


            Mail::to($data['email'])->send(new firmtaskassignMail($data));
        }
            $response = [
                'instruction' => $instruction,
            ];



            // professional Member Notification
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
    public function InstructionGovernment_storedata(Request $request)
    {
        try {
            $userID = auth()->user()->id;
            $method = 'Method => vbpfeedbackController => storedata';
            $inputArray = $request->requestData;
            $input = [
                'stakeholder_id' => $userID,
                'totalid' => $inputArray['totalid'],
                'task_name' => $inputArray['task_name'],
                'cgv_id' => $inputArray['cgv_id'],
                'description' => $inputArray['description'],
                'type' => $inputArray['type'],
            ];

            $instruction =  DB::table('government_task_details')
                ->insertGetId([
                    'stakeholder_id' => $input['stakeholder_id'],
                    'task_name' => $input['task_name'],
                    'task_description' => $input['description'],
                    'status' => 'Active',
                    'created_at' => NOW(),
                    'created_by' => auth()->user()->id,
                ]);

            foreach ($input['totalid'] as $key => $row) {
                $instruction_details_id =  DB::table('government_instruction_details')
                    ->insertGetId([
                        'government_task_id' => $instruction,
                        'instruction_id' => $row['instruction_id'],
                        'status' => 1,
                        'created_at' => NOW(),
                        'created_by' => auth()->user()->id,
                    ]);
            }
            $instruction_details_id =  DB::table('government_task_tracker')
                ->insertGetId([
                    'government_task_id' => $instruction,
                    'user_id' => $input['cgv_id'],
                    'status' => 1,
                    'created_at' => NOW(),
                    'created_by' => auth()->user()->id,
                ]);
            $cgv_name = $this->getusername($input['cgv_id']);
            $stakeholder_name = $this->getusername($userID);
            $this->WriteFileLog('notification');
            $this->WriteFileLog($inputArray['cgv_id'], 'cgv');
            $this->notifications_insert(null, $inputArray['cgv_id'], "Dear $cgv_name, Stakeholder Named $stakeholder_name is assigned you a task kindly look into it.", 'instruction');

            $this->notifications_insert(null, $userID, "Dear $stakeholder_name, Task has been successfully Assigned to a Chief Government Valuer Named $cgv_name", 'instruction');

            $cgv_email = $this->getusermail($input['cgv_id']);
            $base_url = config('setting.base_url');
            $data = array(
                'name' => $cgv_name,
                'email' => $cgv_email,
                'stakeholder_name' => $stakeholder_name,
                'base_url' => $base_url
            );
            Mail::to($data['email'])->send(new stackholderacceptMail($data));

            $this->AuditLog('government_task_details', $instruction, 'create', '#', $userID, Now(), 'Government Stake Holder');
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
