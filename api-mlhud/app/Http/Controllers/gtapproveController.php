<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\If_;
use Illuminate\Support\Facades\Mail;
use App\Mail\approvemail;
use App\Mail\registrarapproveMail;
use App\Mail\counselorsupervisorrejectMail;
use App\Mail\counselorsendMail;
use App\Mail\gtrequestRejectMail;
use App\Mail\registrarwaitingMail;
use App\Mail\registrarrejectMail;
use NunoMaduro\Collision\Contracts\Writer;

class gtapproveController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $logMethod = 'Method => gtapproveController => User';
        try {
            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $role = DB::select("select role_id from uam_user_roles where user_id=$userID");
            $role = $role[0]->role_id;
            // if ($role == "28" || $role == "29") {
            if ($role == "34") {

                $rows = array();
                $rows['rows'] = DB::table('gt_approve_process')
                    ->select('*')
                    ->join('users', 'users.id', '=', 'gt_approve_process.user_id')
                    ->join('gt', 'gt.user_id', '=', 'gt_approve_process.user_id')
                    ->where('gt_approve_process.approval_persons_id', $userID)
                    ->whereNotIn('approval_status', ['No Response'])   
                    ->whereNotIn('gt.active_flag', [0])   
                    ->orderByDesc('gt_approve_process.created_at')
                    ->get();
            } else {


                $rows = array();
                $rows['rows'] = DB::table('gt')
                    ->select('users.name as name', 'gt.interest as interest', 'users.country as country', 'gt.status as approval_status', 'gt.user_id as user_id', 'gt.user_id as approval_persons_id')
                    ->join('users', 'users.id', '=', 'gt.user_id')
                    ->where('gt.active_flag', 1)
                    ->orderByDesc('gt.id')
                    ->get();
            }



            // SELECT*FROM gt_approve_process inner join users ON users.id=gt_approve_process.user_id 
            // inner join gt ON gt.user_id=gt_approve_process.user_id  WHERE 
            // gt_approve_process.approval_persons_id ='152'


            // DB::table('valuer_list')
            //         ->select('*')
            //         // ->join('user_general_details','users.a_user_id','=','user_general_details.user_id')
            //         ->join('user_general_details','user_general_details.id','=','valuer_list.user_id')
            //         ->join('uam_user_roles','uam_user_roles.user_id','=','valuer_list.user_id')
            //         ->join('messages','messages.valuer_id','=','valuer_list.valuer_id')
            //         ->where('valuer_list.assigned_to_id', $userID)   
            //         ->get();


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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function certificate_issue(Request $request)
    // {
    //     $logMethod = 'Method => ValuerController => User';
    //     try {
    //         $v_user_id = $request['user_id'];

    //         $valuer_id = DB::select("select valuer_id from valuer_list where user_id=$v_user_id");
    //         $valuer_id = $valuer_id[0]->valuer_id;
    //         $rows['rows'] = DB::select("SELECT  * from uam_user_roles INNER JOIN users on uam_user_roles.user_id=users.id where uam_user_roles.role_id=19;");
    //         $rows['general'] = DB::select("SELECT * from user_general_details inner join valuer_list on user_general_details.user_id=valuer_list.user_id where user_general_details.user_id=$v_user_id;");
    //         $rows['education'] = DB::select("SELECT * FROM user_education_dip_details where user_id=$v_user_id UNION ALL SELECT * FROM user_education_ug_details where user_id=$v_user_id UNION ALL SELECT * FROM user_education_pg_details where user_id=$v_user_id ;");
    //         $rows['messages'] = DB::select("select * from messages where  valuer_id=$valuer_id;");
    //         $rows['certification'] = DB::select("select * from user_exp_cert_details where user_id=$v_user_id;");
    //         $work_exp = DB::select("select wrqch from user_exp_details where user_id=$v_user_id;");
    //         $wrqch = $work_exp[0]->wrqch;
    //         if ($wrqch == "yes") {
    //             $rows['work_experience'] = DB::select("select * from user_exp_wrq_details where user_id=$v_user_id;");
    //         } else {
    //             $rows['work_experience'] = DB::select("select * from user_exp_wre_details where user_id=$v_user_id;");
    //         }
    //         $rows['wrqch'] = $wrqch;





    //         // DB::table('valuer_list')
    //         //         ->select('*')
    //         //         // ->join('user_general_details','users.a_user_id','=','user_general_details.user_id')
    //         //         ->join('user_general_details','user_general_details.id','=','valuer_list.user_id')
    //         //         ->join('uam_user_roles','uam_user_roles.user_id','=','valuer_list.user_id')
    //         //         ->join('messages','messages.valuer_id','=','valuer_list.valuer_id')
    //         //         ->where('valuer_list.assigned_to_id', $userID)   
    //         //         ->get();





    //         $serviceResponse = array();
    //         $serviceResponse['Code'] = config('setting.status_code.success');
    //         $serviceResponse['Message'] = config('setting.status_message.success');
    //         $serviceResponse['Data'] = $rows;
    //         $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
    //         $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
    //         return $sendServiceResponse;
    //     } catch (\Exception $exc) {
    //         $exceptionResponse = array();
    //         $exceptionResponse['ServiceMethod'] = $logMethod;
    //         $exceptionResponse['Exception'] = $exc->getMessage();
    //         $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
    //         $serviceResponse = array();
    //         $serviceResponse['Code'] = config('setting.status_code.exception');
    //         $serviceResponse['Message'] = $exc->getMessage();
    //         $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
    //         $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
    //         return $sendServiceResponse;
    //     }
    // }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $method = 'Method => UamModulesController => data_edit';
            $id = $this->decryptData($id);
            $stake_holder = DB::select("SELECT assigned_to_id FROM valuer_list WHERE user_id=$id;");
            $stake_holder_id = $stake_holder[0]->assigned_to_id;
            $rows['rows'] = DB::select("SELECT  * from uam_user_roles INNER JOIN users on uam_user_roles.user_id=users.id where uam_user_roles.role_id=19;");
            $rows['general'] = DB::select("SELECT * from user_general_details inner join valuer_list on user_general_details.user_id=valuer_list.user_id where user_general_details.user_id=$id and user_general_details.active_flag='0';");
            $rows['education'] = DB::select("SELECT * FROM user_education_dip_details where user_id=$id UNION ALL SELECT  * FROM user_education_ug_details where user_id=$id UNION ALL SELECT * FROM user_education_pg_details where user_id=$id ;");
            $rows['messages'] = DB::select("select * from messages where valuer_id=$id;");
            $rows['certification'] = DB::select("select * from user_exp_cert_details where user_id=$id;");
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


    public function approveupdate(Request $request)
    {

        try {

            $method = 'Method => gtapproveController => storedata';
            $inputArray = $request->requestData;
            $inputArray = $this->decryptData($inputArray);

            $userID = Auth::id();
            $role = DB::select("select role_id from uam_user_roles where user_id=$userID");
            $role = $role[0]->role_id;
            $input = [
                'gt_id' => $inputArray['gt_id'],
                'user_id' => $userID,
                'message' => $inputArray['messages']
            ];


            if ($role != '30') {
                DB::transaction(function () use ($input) {
                    $update_id =  DB::table('gt_approve_process')
                        ->where([['approval_persons_id',  $input['user_id']]])
                        ->where([['user_id', $input['gt_id']]])
                        ->update([
                            'status' => 1,
                            'approval_status' => 'Approved',

                        ]);
                });



                if ($input['gt_id'] == '29') {
                    // notification for the GT
                    $notifications = DB::table('notifications')->insertGetId([
                        'user_id' => $input['gt_id'],
                        'notification_status' => 'Counselor Approved GT ',
                        'notification_url' => 'approvalprocess_index',
                        'megcontent' => "You have been approved Sucessfully by Counselor.",
                        'alert_meg' => "You have been approved Sucessfully by Counselor.",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    $gt_id = $input['gt_id'];
                    $users = DB::select("SELECT name FROM users where id= '$userID';");
                    $user_name = $users[0]->name;
                    $name = $user_name . '(GT)';

                    // notification for counselor
                    $notifications = DB::table('notifications')->insertGetId([

                        'user_id' => $userID,
                        'notification_status' => 'Supervisor/counselor Approved GT',
                        'notification_url' => 'gtapprove',
                        'megcontent' => "You have successfully Approved $name.",
                        'alert_meg' => "You have Sucessfully Approved $name.",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                } else {
                    $notifications = DB::table('notifications')->insertGetId([
                        'user_id' => $input['gt_id'],
                        'notification_status' => 'Supervisor Approved GT',
                        'notification_url' => 'approvalprocess_index',
                        'megcontent' => "You have been approved Sucessfully by the Supervisor.",
                        'alert_meg' => "You have been approved Sucessfully by the Supervisor.",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);

                    $gt_id = $input['gt_id'];
                    $users = DB::select("SELECT name FROM users where id= '$gt_id';");
                    $user_name = $users[0]->name;
                    $name = $user_name . '(GT)';
                    // notication for supervisor
                    $notifications = DB::table('notifications')->insertGetId([

                    'user_id' => $userID,
                        'notification_status' => 'Supervisor/counselor Approved GT',
                        'notification_url' => 'gtapprove',
                        'megcontent' => "You have successfully Approved $name.",
                        'alert_meg' => "You have Sucessfully Approved $name.",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                }


                $user_id = $input['gt_id'];
                $approve_count = DB::select("select count(id) as count from gt_approve_process where status = '1'and user_id ='$user_id'");

                $approve_count = $approve_count[0]->count;

                if ($approve_count == '2') {
                    DB::transaction(function () use ($input) {
                        $update_id =  DB::table('gt')
                            ->where([['user_id', $input['gt_id']]])
                            ->update([
                                'active_flag' => 1,
                            ]);
                    });


                    $email = $this->getusermail($input['gt_id']);
                    $name = $this->getusername($input['gt_id']);
                    $base_url = config('setting.base_url');

                    $data = array(
                        'name' => $name,
                        'email' => $email,
                        'base_url' => $base_url

                    );
                    Mail::to($data['email'])->send(new approvemail($data));


                    $gt_name = $this->getusername($input['gt_id']);
                    $users_list = $this->get_userson_roles(config('setting.roles.registrar'));
                    $base_url = config('setting.base_url');


                    foreach ($users_list as $user) {
                        $data = array(
                            'name' => $user->name,
                            'email' => $user->email,
                            'user_name' => $gt_name,
                            'base_url' => $base_url


                        );
                        Mail::to($data['email'])->send(new registrarwaitingMail($data));
                    }

                    $gt_id = $input['gt_id'];
                    $users = DB::select("SELECT name FROM users where id= '$gt_id';");
                    $user_name = $users[0]->name;
                    $name = $user_name . '(GT)';

                    $notifications = DB::table('notifications')->insertGetId([

                        'notification_status' => `Graduate Trainee is waiting for your Approval.`,
                        'notification_url' => 'gtapprove',
                        'megcontent' => "$name is waiting for your Approval.",
                        'alert_meg' => "$name is waiting for your Approval.",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW(),
                        'role_id' => '30'
                    ]);
                }
                if ($role == '28') {
                    $message = "Supervisor";
                }
                if ($role == '29') {
                    $message = "Counselor";
                }


                if (is_null($input['message']) != '1') {
                    $approver_message =  DB::table('messages')
                        ->insertGetId([
                            'gt_approval_persons_id' => $input['user_id'],
                            'message' => $input['message'],
                            'gt_id' => $input['gt_id'],
                            'flag' => 0,
                            'created_at' => NOW(),
                        ]);
                }
            } else {
                $user_id = $input['gt_id'];

                DB::transaction(function () use ($input) {
                    $update_id =  DB::table('gt')

                        ->where([['user_id', $input['gt_id']]])
                        ->update([
                            'status' => 'Approved',
                            'updated_at' => NOW(),


                        ]);
                });

                $email = $this->getusermail($input['gt_id']);
                $name = $this->getusername($input['gt_id']);
                $base_url = config('setting.base_url');

                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'base_url' => $base_url
                );


                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => $input['gt_id'],
                    'notification_status' => 'Registrar Approved GT ',
                    'notification_url' => 'Committee_index',
                    'megcontent' => "Your application has been approved Sucessfully by Registrar.",
                    'alert_meg' =>  "Your application has been approved Sucessfully by Registrar.",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);

                $role_id = DB::table('uam_user_screens')
                    ->insertGetId([


                        'user_id' => $input['gt_id'],
                        'module_id' => '8',
                        'parent_module_id' => '1',
                        'module_name' => 'E-learning',
                        'screen_id' => '9',
                        'screen_name' => 'E-learning',
                        'route_url' => 'elearningDashboard',
                        'screen_url' => 'elearningDashboard',
                        'display_order' => '10',
                        'created_by' => '1',
                        'active_flag' => 0,
                        'created_date' => NOW(),
                    ]);
                $role_id = DB::table('uam_user_screens')
                    ->insertGetId([


                        'user_id' => $input['gt_id'],
                        'module_id' => '20',
                        'parent_module_id' => '1',
                        'module_name' => 'Assessment',
                        'screen_id' => '38',
                        'screen_name' => 'Professional/Competence',
                        'route_url' => 'Professional/Competence',
                        'screen_url' => 'Professional/Competence',
                        'display_order' => '1',
                        'created_by' => '1',
                        'active_flag' => 0,
                        'created_date' => NOW(),
                    ]);
                $role_id = DB::table('uam_user_screens')
                    ->insertGetId([


                        'user_id' => $input['gt_id'],
                        'module_id' => '20',
                        'parent_module_id' => '1',
                        'module_name' => 'Assessment',
                        'screen_id' => '46',
                        'screen_name' => 'Critical Anaysis report',
                        'route_url' => 'Critical/Report',
                        'screen_url' => 'Critical/Report',
                        'display_order' => '2',
                        'created_by' => '1',
                        'active_flag' => 0,
                        'created_date' => NOW(),
                    ]);

                $update_id =  DB::table('uam_user_roles')
                    ->where([['user_id', $input['gt_id']]])
                    ->update([
                        'active_flag' => 0,


                    ]);

                $registrar_message =  DB::table('messages')
                    ->insertGetId([
                        'gt_approval_persons_id' => $input['user_id'],
                        'message' => $input['message'],
                        'gt_id' => $input['gt_id'],
                        'flag' => 0,
                        'created_at' => NOW(),
                    ]);


                    Mail::to($data['email'])->send(new registrarapproveMail($data));



                if ($role == '29') {
                    $notifications = DB::table('notifications')->insertGetId([
                        'user_id' => auth()->user()->id,
                        'notification_status' => `Commitee has Approved you Successfully`,
                        'notification_url' => 'Registration',
                        'megcontent' => "Commitee has Approved you Successfully.",
                        'alert_meg' => "Commitee has Approved you Successfully.",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()

                    ]);
                }
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






    public function rejectupdate(Request $request)
    {

        try {

            $method = 'Method => gtapproveController => storedata';
            $inputArray = $request->requestData;
            $inputArray = $this->decryptData($inputArray);

            $userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];
            $userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];
            $role = DB::select("select role_id from uam_user_roles where user_id=$userID");
            $role = $role[0]->role_id;
            $input = [
                'gt_id' => $inputArray['gt_id'],
                'user_id' => $userID,

            ];

            DB::transaction(function () use ($input) {
                $update_id =  DB::table('gt_approve_process')
                    ->where([['approval_persons_id',  $input['user_id']]])
                    ->where([['user_id', $input['gt_id']]])
                    ->update([
                        'status' => 2,
                        'approval_status' => 'Rejected',

                    ]);
            });



            $rows = DB::select("SELECT role_id,is_supervisor from uam_user_roles inner join users on users.id = uam_user_roles.user_id where uam_user_roles.user_id=$userID");


            if ($rows[0]->is_supervisor == 2) {
                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => $input['gt_id'],
                    'notification_status' => 'Counselor Rejected GT ',
                    'notification_url' => 'approvalprocess_index',
                    'megcontent' => "You have been Rejected Sucessfully by Counselor.",
                    'alert_meg' => "You have been Rejected Sucessfully by Counselor.",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);
                $email = $this->getusermail($input['gt_id']);
                $name = $this->getusername($input['gt_id']);
                $base_url = config('setting.base_url');

                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'type' => "Counselor",
                    'base_url' => $base_url
                );
            } else {
                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => $input['gt_id'],
                    'notification_status' => 'Supervisor Rejected GT',
                    'notification_url' => 'approvalprocess_index',
                    'megcontent' => "Your Application has  been Rejected by Supervisor.",
                    'alert_meg' => "Your Application has  been Rejected by Supervisor.",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);
                $email = $this->getusermail($input['gt_id']);
                $name = $this->getusername($input['gt_id']);
                $base_url = config('setting.base_url');

                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'type' => "Supervisor",
                    'base_url' => $base_url
                );
            }
            Mail::to($data['email'])->send(new counselorsupervisorrejectMail($data));



            if ($rows[0]->is_supervisor == 1) {
                $message = "Supervisor";
            }
            if ($rows[0]->is_supervisor == 2) {
                $message = "Counselor";
            }
            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => `$message Rejected GT`,
                'notification_url' => 'gtapprove',
                'megcontent' => "Rejected the Graduate Trainee Successfully.",
                'alert_meg' => "Rejected the Graduate Trainee Successfully.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()

            ]);



            // DB::transaction(function () use ($input) {
            //     $update_id =  DB::table('gt_approve_process ')
            //         ->where([['approval_persons_id',  $input['user_id']]])
            //         ->where([['user_id', $input['gt_id']]])
            //         ->update([
            //             'status' => 1,
            //             'approval_status' => 'Approved',

            //         ]);

            //     });



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


    public function approvereject(Request $request)
    {
        $this->WriteFileLog('fe');

        try {

            $method = 'Method => gtapproveController => storedata';
            $inputArray = $request->requestData;
            $inputArray = $this->decryptData($inputArray);
            $userID = auth()->user()->id;



            $input = [
                'counselor' => $inputArray['counselor'],
                'supervisor' => $inputArray['supervisor'],
                'gt_id' => $userID
            ];


            if (is_null($input['counselor']) != '1' &&  (is_null($input['supervisor']) != '1')) {
                for ($i = 0; $i < 1; $i++) {
                    DB::table("gt_approve_process")
                        ->where('user_id', $input['gt_id'])->delete();
                }
                $update_id =  DB::table('gt_approve_process')
                    ->insertGetId([
                        'approval_persons_id' => $input['counselor'],
                        'user_id' => $input['gt_id'],
                        'approval_status' => "Pending",
                        'status' => NULL,
                        'role_id' => '29',
                        'active_flag' => 0,
                        'created_at' => NOW(),
                    ]);
                // mail counselor

                $email = $this->getusermail($input['counselor']);
                $name = $this->getusername($input['counselor']);
                $user_name = $this->getusername($input['gt_id']);
                $base_url = config('setting.base_url');

                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'user_name' => $user_name,
                    'base_url' => $base_url
                );

                Mail::to($data['email'])->send(new counselorsendMail($data));


                $update_id =  DB::table('gt_approve_process')
                    ->insertGetId([
                        'approval_persons_id' => $input['supervisor'],
                        'user_id' => $input['gt_id'],
                        'approval_status' => "Pending",
                        'status' => NULL,
                        'role_id' => '28',
                        'active_flag' => 0,
                        'created_at' => NOW(),
                    ]);

                //mail  supervisor

                $email = $this->getusermail($input['supervisor']);
                $name = $this->getusername($input['supervisor']);
                $user_name = $this->getusername($input['gt_id']);
                $base_url = config('setting.base_url');


                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'user_name' => $user_name,
                    'base_url' => $base_url
                );

                Mail::to($data['email'])->send(new counselorsendMail($data));



                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.success');
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 1;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                return $sendServiceResponse;
            }




            if (is_null($input['counselor']) != '1') {

                DB::transaction(function () use ($input) {
                    $update_id =  DB::table('gt_approve_process')
                        ->where([['approval_status', 'Rejected']])
                        ->where([['user_id', $input['gt_id']]])
                        ->orWhere([['approval_status', 'No Response']])
                        ->update([
                            'approval_persons_id' => $input['counselor'],
                            'status' => NULL,
                            'approval_status' => 'Pending',

                        ]);
                });
                //waiting mail counselor

                $email = $this->getusermail($input['counselor']);
                $name = $this->getusername($input['counselor']);
                $user_name = $this->getusername($input['gt_id']);
                $base_url = config('setting.base_url');


                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'user_name' => $user_name,
                    'base_url' => $base_url
                );

                Mail::to($data['email'])->send(new counselorsendMail($data));
            }

            if (is_null($input['supervisor']) != '1') {

                DB::transaction(function () use ($input) {
                    $update_id =  DB::table('gt_approve_process')
                        ->where([['approval_status', 'Rejected']])
                        ->where([['user_id', $input['gt_id']]])
                        ->orWhere([['approval_status', 'No Response']])
                        ->update([
                            'approval_persons_id' => $input['supervisor'],
                            'status' => NULL,
                            'approval_status' => 'Pending',

                        ]);
                });


                $email = $this->getusermail($input['supervisor']);
                $name = $this->getusername($input['supervisor']);
                $user_name = $this->getusername($input['gt_id']);
                $base_url = config('setting.base_url');

                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'user_name' => $user_name,
                    'base_url' => $base_url
                );

                Mail::to($data['email'])->send(new counselorsendMail($data));
                
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


    public function changereject(Request $request)
    {

        try {

            $method = 'Method => gtapproveController => changereject';
            $inputArray = $request->requestData;
            $inputArray = $this->decryptData($inputArray);
            $userID = auth()->user()->id;
            $input = [
                'counselor' => $inputArray['counselor'],
                'supervisor' => $inputArray['supervisor'],
                'messages' => $inputArray['messages'],
                'gt_id' => $userID
            ];

            $approval_persons_id = ($inputArray['supervisor'] != "" ? $inputArray['supervisor'] : 0) . ',' . ($inputArray['counselor'] != "" ? $inputArray['counselor'] : 0);
            $gt_users_update = DB::select("SELECT approval_count_gt FROM users WHERE id = $userID");
            $approval_count = $gt_users_update[0]->approval_count_gt;
            if ($approval_count > 2) {
                $is_requested = DB::table("supervisor_requests")
                    ->where('user_id', $userID)
                    ->count();
                if ($is_requested == 0) {
                    DB::transaction(function () use ($userID, $approval_persons_id) {
                        DB::table('supervisor_requests')->insertGetId([
                            'user_id' => $userID,
                            'approval_persons_id' => $approval_persons_id,
                            'created_at' => now(),
                            'status' => 1
                        ]);
                    });
                    $name = $this->getusername($userID);
                    $this->notifications_insert(1, null, "Special Request", "request_gt");
                }

                $serviceResponse = array();
                $serviceResponse['Code'] = 400;
                $serviceResponse['Message'] = "You need a Special Request from Admin in order to do the change kindly wait for the approval.";
                $serviceResponse['Data'] = 1;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                return $sendServiceResponse;
            }

            $approval_count++;
            $existingMessages = DB::table('users')
                ->where('id', $input['gt_id'])
                ->value('messages');
            if ($existingMessages == null) {
                $existingMessagesArray = '';
            } else {
                $existingMessagesArray = json_decode($existingMessages, true);
            }
            if ($existingMessagesArray == '') {
                $mergedMessages = $input['messages'];
            } else {
                $mergedMessages = $existingMessagesArray . '|' . $input['messages'];
            }

            DB::transaction(function () use ($input, $approval_count, $mergedMessages) {
                $update_id =  DB::table('users')
                    ->where([['id', $input['gt_id']]])
                    ->update([
                        'approval_count_gt' => $approval_count,
                        'messages' => json_encode($mergedMessages),
                    ]);
            });


            $gt_change = DB::select("SELECT *,gt.is_supervisor as gt_is_supervisor from gt_approve_process AS gt INNER JOIN users AS u ON u.id = gt.approval_persons_id where gt.user_id = $userID");
            $existing_counselor_id =0;
            $existing_supervisor_id = 0;
            foreach ($gt_change as $key => $row) {
                if ($row->gt_is_supervisor == 2) {
                    $existing_counselor_id = $row->approval_persons_id;
                } else {
                    $existing_supervisor_id = $row->approval_persons_id;
                }
            }
            $councellor = $inputArray['counselor'];
            $supervisor = $inputArray['supervisor'];

            if ($councellor != $existing_counselor_id && $councellor != '') {
                $this->WriteFileLog('supervisor');
                $update_id =  DB::table('gt_approve_process')
                    ->where([['user_id', $input['gt_id']]])
                    ->where([['approval_persons_id', $existing_counselor_id]])
                    ->update([
                        'status' =>  NULL,
                        'approval_status' => 'Pending',
                        'approval_persons_id' => $councellor,
                        'is_supervisor' => '2',
                        'created_at' => NOw()

                    ]);
                // $update_id =  DB::table('users')
                //     ->where('id', $councellor)
                //     ->update([
                //         'is_supervisor' => 2,

                //     ]);

                $name = $this->getusername($userID);
                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => $userID,
                    'notification_status' => 'Counselor/Supervisor Selected ',
                    'notification_url' => 'approvalprocess_index',
                    'megcontent' => "Dear $name you has been selected the Counsellor/supervisor successfully.",
                    'alert_meg' => "Dear $name you has been selected the Counsellor/supervisor successfully.",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);

                $name = $this->getusername($councellor);
                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => $councellor,
                    'notification_status' => 'Counselor/Supervisor Selected ',
                    'notification_url' => 'gtapprove',
                    'megcontent' => "$name is awaiting for your approval",
                    'alert_meg' => "$name is awaiting for your approval",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);

                $email = $this->getusermail($councellor);
                $base_url = config('setting.base_url');
                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'user_name' => $name,
                    'base_url' => $base_url
                );

                Mail::to($email)->send(new counselorsendMail($data));

                $this->auditLog('gt_approve_process', $update_id, 'Update', 'Reselected the Counselor/Supervisor Details', $userID, NOW(), 'GT');
            }
            if ($supervisor != $existing_supervisor_id && $supervisor != '') {

                $update_id =  DB::table('gt_approve_process')
                    ->where([['user_id',  $input['gt_id']]])
                    ->where([['approval_persons_id', $existing_supervisor_id]])
                    ->update([
                        'status' =>  NULL,
                        'approval_status' => 'Pending',
                        'approval_persons_id' => $supervisor,
                        'is_supervisor' => 1,
                        'created_at' => NOw()
                    ]);
                // $update_id =  DB::table('users')
                //     ->where('id', $supervisor)
                //     ->update([
                //         'is_supervisor' => 1,

                //     ]);

                $name = $this->getusername($userID);
                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => $userID,
                    'notification_status' => 'Counselor/Supervisor Selected ',
                    'notification_url' => 'approvalprocess_index',
                    'megcontent' => "Dear $name you has been selected the Counsellor/supervisor successfully.",
                    'alert_meg' => "Dear $name you has been selected the Counsellor/supervisor successfully.",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);

                $name = $this->getusername($supervisor);
                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => $supervisor,
                    'notification_status' => 'Counselor/Supervisor Selected ',
                    'notification_url' => 'gtapprove',
                    'megcontent' => "$name is awaiting for your approval",
                    'alert_meg' => "$name is awaiting for your approval",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);

                $email = $this->getusermail($supervisor);
                $base_url = config('setting.base_url');
                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'user_name' => $name,
                    'base_url' => $base_url
                );

                Mail::to($email)->send(new counselorsendMail($data));
                $this->auditLog('gt_approve_process', $update_id, 'Update', 'Reselected the Counselor/Supervisor Details', $userID, NOW(), 'GT');
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


    public function rejecter(Request $request)
    {


        try {

            $method = 'Method => gtapproveController => rejecter';
            $inputArray = $request->requestData;
            $inputArray = $this->decryptData($inputArray);
            $userID = $inputArray['gt_id'];


            $input = [
                'gt_id' => $userID

            ];

            // delete general 
            $uelid = DB::table('user_general_details')
                ->where('user_id', $input['gt_id'])
                ->update([
                    'active_flag' => '1',
                    'updated_at' => NOW(),
                ]);


            // education delete

            $education_check = DB::select("select * from user_education_dip_details where user_id = '$userID' and active_flag='0' ");

            $uelid = DB::table('user_education_dip_details')
                ->where('user_id', $userID)
                ->delete();
            // $this->WriteFileLog($education_check);
            // $ug = $education_check[0]->ugc;
            // $pg = $education_check[0]->pgc;
            // $dip = $education_check[0]->dipc;

            // $uelid = DB::table('user_education_details')
            //     ->where('user_id', $userID)
            //     ->delete();

            // if ($ug != 0) {
            //     $uelid = DB::table('user_education_ug_details')
            //         ->where('user_id', $userID)
            //         ->delete();
            // }


            // if ($pg != 0) {
            //     $uelid = DB::table('user_education_pg_details')
            //         ->where('user_id', $userID)
            //         ->delete();
            // }

            // if ($dip != 0) {

            // }


            // delete experience


            // $uelid = DB::table('user_exp_details')
            //     ->where('user_id', $userID)
            //     ->delete();
            // $wre_check = DB::select("select * from user_exp_wre_details where user_id = '$userID' and active_flag='0' ");


            // if ($wre_check != []) {
            //     $uelid = DB::table('user_exp_wre_details')
            //         ->where('user_id', $userID)
            //         ->delete();
            // }

            // $wrq_check = DB::select("select * from user_exp_wrq_details where user_id = '$userID' and active_flag='0' ");


            $uelid = DB::table('user_exp_wrq_details')
                ->where('user_id', $userID)
                ->delete();
            // $cert_check = DB::select("select * from user_exp_cert_details where user_id = '$userID' and active_flag='0' ");


            // if ($cert_check != []) {
            //     $uelid = DB::table('user_exp_cert_details')
            //         ->where('user_id', $userID)
            //         ->delete();
            // }

            for ($i = 0; $i < 1; $i++) {
                DB::table("gt_approve_process")
                    ->where('user_id', $input['gt_id'])->delete();
            }

            $uelid = DB::table('gt')
                ->where('user_id', $input['gt_id'])
                ->update([
                    'active_flag' => '2',
                ]);

            $message = DB::select("select count(id) as count from messages where gt_id = $userID");
            for ($i = 0; $i < $message[0]->count; $i++) {
                $uelid = DB::table('messages')
                    ->where('gt_id', $userID)
                    ->delete();
            }

            $email = $this->getusermail($input['gt_id']);
            $name = $this->getusername($input['gt_id']);
            $base_url = config('setting.base_url');

            $data = array(
                'name' => $name,
                'email' => $email,
                'base_url' => $base_url
            );

            Mail::to($data['email'])->send(new registrarrejectMail($data));




            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => $input['gt_id'],
                'notification_status' => 'Registrar Rejected GT ',
                'notification_url' => 'Registration',
                'megcontent' => "Your application has Rejected sucessfully by Registrar.",
                'alert_meg' => "Your application has Rejected sucessfully by Registrar.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => $userID,
                'notification_status' => 'GT Rejected By Registrar ',
                'notification_url' => 'gtapprove',
                'megcontent' => "Rejected The Graduate Trainee Successfully.",
                'alert_meg' => "Rejected The Graduate Trainee Successfully.",
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




    public function storedata(Request $request)
    {
        try {
            $method = 'Method => General_registation => storedata';
            $inputArray = $request->requestData;
            $user_id = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];
            $valuer_code = json_encode(DB::select("select valuer_code from valuer_list"));

            if ($valuer_code == '[]') {
                $valuer_code = "VR/L/001";
            } else {
                $valuer_code = (DB::table('valuer_list')->orderBy('valuer_id', 'desc')->first());
                $valuer_code_new = $valuer_code->valuer_code;
                $valuer_code = ++$valuer_code_new;
            }
            $status = "Pending";
            $input = [
                'user_id' => $user_id,
                'valuer_code' => $valuer_code,
                'status' => $status,

            ];



            DB::transaction(function () use ($input) {
                $role_id = DB::table('valuer_list')
                    ->insertGetId([
                        'user_id' => $input['user_id'],
                        'valuer_code' => $input['valuer_code'],
                        'v_status' => $input['status'],
                        'created_at' => NOW(),

                    ]);
            });

            DB::table('user_payment_details')
                ->where('user_id', $input['user_id'])
                ->update(['requested_at' => now()]);



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
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }


    public function approve_index(Request $request)
    {

        try {

            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];



            //for valuer approve (valers list)

            $gt_id = $request->gt_id;
            $approval_persons_id = $request->approval_persons_id;
            $method = 'Method => ajaxController => index';
            $role = DB::select("SELECT role_id FROM uam_user_roles where user_id=$userID;");
            $role = $role[0]->role_id;


            if ($role == "34" || $role == "30") {
                $rows['general'] = DB::select("SELECT * FROM user_general_details inner join gt on user_general_details.user_id=gt.user_id  inner join users as u on u.id=user_general_details.user_id where gt.user_id=$gt_id and user_general_details.active_flag='0';");
                $rows['education'] = DB::select("SELECT * FROM user_education_dip_details where user_id=$gt_id and active_flag='0'");

                $rows['work_experience'] = DB::select("select * from user_exp_wrq_details where user_id=$gt_id and user_exp_wrq_details.active_flag='0';");


                $rows['certification'] = DB::select("select * from user_exp_cert_details where user_id=$gt_id    and user_exp_cert_details.active_flag='0';");

                $rows['messages'] = DB::select("SELECT * FROM messages AS m INNER JOIN users ON m.gt_approval_persons_id=users.id inner join uam_user_roles as ur on ur.user_id= m.gt_approval_persons_id WHERE gt_id=$gt_id");

                // $rows['data3'] = DB::table('users')
                //     ->select('*')
                //     ->Join('gt_approve_process', 'users.id', '=', 'gt_approve_process.approval_persons_id')
                //     ->Join('uam_roles', 'uam_roles.role_id', '=', 'gt_approve_process.role_id')
                //     ->where('gt_approve_process.user_id', $gt_id)
                //     ->get();
                $rows['data3'] = DB::table('users')
                ->select('users.*', 'gap.id', 'gap.user_id', 'gap.approval_persons_id', 'gap.approval_status', 'gap.status', 'gap.active_flag', 'gap.role_id', 'gap.is_supervisor AS gt_role_name','gap.created_at as approved_on', 'ur.*')
                ->join('gt_approve_process AS gap', 'users.id', '=', 'gap.approval_persons_id')
                ->join('uam_roles AS ur', 'ur.role_id', '=', 'gap.role_id')
                ->where('gap.user_id', $gt_id)
                ->get();
            } else {
                $valuer_id = $request->valuer_id;
                $v_user_id = $request->v_user_id;

                $rows['rows'] = DB::select("SELECT * from uam_user_roles INNER JOIN users on uam_user_roles.user_id=users.id where uam_user_roles.role_id=19;");
                $rows['general'] = DB::select("  SELECT * from user_general_details inner join gt on user_general_details.user_id=gt.user_id where user_general_details.user_id=141 and user_general_details.active_flag='0'
                    $v_user_id and user_general_details.active_flag='0';");
                $rows['education'] = DB::select("SELECT * FROM user_education_dip_details where user_id=$v_user_id  and user_education_dip_details.active_flag='0'");
                $rows['certification'] = DB::select("select * from user_exp_cert_details where user_id=$v_user_id and user_exp_cert_details.active_flag='0';");
                $work_exp = DB::select("select wrqch from user_exp_details where user_id=$v_user_id and user_exp_details.active_flag='0';");
                $wrqch = $work_exp[0]->wrqch;
                if ($wrqch == "yes") {

                    $rows['work_experience'] = DB::select("select * from user_exp_wrq_details where user_id=$v_user_id and user_exp_wrq_details.active_flag='0';");
                } else {
                    $rows['work_experience'] = DB::select("select * from user_exp_wre_details where user_id=$v_user_id and user_exp_wre_details.active_flag='0';");
                }
                $rows['wrqch'] = $wrqch;
            }

            //for certficate index page (registration certificate) 


            // $response = [
            //     'rows' => $users,
            //     'general' => $generaldetails
            // ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $rows;
            $serviceResponse['role'] = $role;
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
    public function request_gt(Request $request)
    {
        try {
            $this->WriteFileLog('hitted');
            $method = 'Method => gtapproveController => request_gt';
            $userID = auth()->user()->id;
            $rows = DB::table('supervisor_requests')
                ->Join('users', 'users.id', '=', 'supervisor_requests.user_id')
                ->orderByDesc('supervisor_requests.created_at')
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
    public function specialRequest(Request $request)
    {
        try {
            $method = 'Method => gtapproveController => specialRequest';
            $userID = auth()->user()->id;
            $requestData = $request->requestData;

            $inputArray = $this->DecryptData($requestData);
            $gt_id = $inputArray['gt_id'];
            $rows = $this->GetEndUserData($gt_id);
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
    public function requestUpdate(Request $request)
    {
        try {
            $method = 'Method => gtapproveController => request_gt';
            $userID = auth()->user()->id;
            $requestData = $request->requestData;
            $inputArray = $this->DecryptData($requestData);
            $is_approve = $inputArray['is_status'];
            $gt_id = $inputArray['gt_id'];

            $approval_persons_id = DB::table('supervisor_requests')
                ->where('user_id', $gt_id)
                ->value('approval_persons_id');
            $approval_persons_Array = explode(',', $approval_persons_id);
            $this->WriteFileLog($approval_persons_Array);

            $counselor = $approval_persons_Array[1];
            $supervisor = $approval_persons_Array[0];
            $gt_change = DB::select("SELECT *,gt.is_supervisor as gt_is_supervisor from gt_approve_process AS gt INNER JOIN users AS u ON u.id = gt.approval_persons_id where gt.user_id = $gt_id");
            $existing_counselor_id =0;
            $existing_supervisor_id =0;
            foreach ($gt_change as $key => $row) {
                if ($row->gt_is_supervisor == 2) {
                    $existing_counselor_id = $row->approval_persons_id;
                } else {
                    $existing_supervisor_id = $row->approval_persons_id;
                }
            }
            if ($is_approve == '1') {
                if ($counselor != 0) {
                    $update_id =  DB::table('gt_approve_process')
                        ->where([['user_id',  $gt_id]])
                        ->where([['approval_persons_id', $existing_counselor_id]])
                        ->update([
                            'status' =>  NULL,
                            'approval_status' => 'Pending',
                            'approval_persons_id' => $counselor,
                            'is_supervisor' => 2
                        ]);
                    // $update_id =  DB::table('users')
                    //     ->where('id', $counselor)
                    //     ->update([
                    //         'is_supervisor' => 2,

                    //     ]);

                    // $name = $this->getusername($userID);
                    // $notifications = DB::table('notifications')->insertGetId([
                    //     'user_id' => $userID,
                    //     'notification_status' => 'Counselor/Supervisor Selected ',
                    //     'notification_url' => 'approvalprocess_index',
                    //     'megcontent' => "Dear $name you has been selected the Counsellor/supervisor successfully.",
                    //     'alert_meg' => "Dear $name you has been selected the Counsellor/supervisor successfully.",
                    //     'created_by' => auth()->user()->id,
                    //     'created_at' => NOW()
                    // ]);

                    $name = $this->getusername($counselor);
                    $notifications = DB::table('notifications')->insertGetId([
                        'user_id' => $counselor,
                        'notification_status' => 'Counselor/Supervisor Selected ',
                        'notification_url' => 'gtapprove',
                        'megcontent' => "$name is awaiting for your approval",
                        'alert_meg' => "$name is awaiting for your approval",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);

                    $email = $this->getusermail($counselor);

                    $user_name = $this->getusername($gt_id);

                    $base_url = config('setting.base_url');
                    $data = array(
                        'name' => $name,
                        'email' => $email,
                        'user_name' => $user_name,
                        'base_url' => $base_url
                    );

                    Mail::to($email)->send(new counselorsendMail($data));
                    $this->auditLog('gt_approve_process', $update_id, 'Update', 'Reselected the Counselor/Supervisor Details', $gt_id, NOW(), 'GT');
                }
                if ($supervisor != 0) {
                    $update_id =  DB::table('gt_approve_process')
                        ->where([['user_id', $gt_id]])
                        ->where([['approval_persons_id', $existing_supervisor_id]])
                        ->update([
                            'status' =>  NULL,
                            'approval_status' => 'Pending',
                            'approval_persons_id' => $supervisor,
                            'is_supervisor' => 1

                        ]);
                    // $update_id =  DB::table('users')
                    //     ->where('id', $supervisor)
                    //     ->update([
                    //         'is_supervisor' => 1,

                    //     ]);

                    // $name = $this->getusername($userID);
                    // $notifications = DB::table('notifications')->insertGetId([
                    //     'user_id' => $userID,
                    //     'notification_status' => 'Counselor/Supervisor Selected ',
                    //     'notification_url' => 'approvalprocess_index',
                    //     'megcontent' => "Dear $name you has been selected the Counsellor/supervisor successfully.",
                    //     'alert_meg' => "Dear $name you has been selected the Counsellor/supervisor successfully.",
                    //     'created_by' => auth()->user()->id,
                    //     'created_at' => NOW()
                    // ]);

                    $name = $this->getusername($supervisor);
                    $user_name = $this->getusername($gt_id);
                    $notifications = DB::table('notifications')->insertGetId([
                        'user_id' => $supervisor,
                        'notification_status' => 'Counselor/Supervisor Selected ',
                        'notification_url' => 'gtapprove',
                        'megcontent' => "$name is awaiting for your approval",
                        'alert_meg' => "$name is awaiting for your approval",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);

                    $email = $this->getusermail($supervisor);
                    $base_url = config('setting.base_url');
                    $data = array(
                        'name' => $name,
                        'email' => $email,
                        'user_name' => $user_name,
                        'base_url' => $base_url
                    );

                    Mail::to($email)->send(new counselorsendMail($data));

                    $this->auditLog('gt_approve_process', $update_id, 'Update', 'Reselected the Counselor/Supervisor Details', $gt_id, NOW(), 'GT');
                }
                DB::table('supervisor_requests')
                    ->where('user_id', $gt_id)
                    ->delete();
            } else {
                $update_id = DB::table('supervisor_requests')
                    ->where('user_id', $gt_id)
                    ->delete();
                $email = $this->getusermail($gt_id);
                $base_url = config('setting.base_url');
                $Gt_name = $this->getusername($gt_id);

                $data = array(
                    'name' => $Gt_name,
                    'email' => $email,
                    'user_name' => $Gt_name,
                    'base_url' => $base_url
                );

                Mail::to($email)->send(new gtrequestRejectMail($data));
                $admin_notification = $this->notifications_insert(null, $userID, "Supervision Request Rejected for the GT " . $Gt_name, '#');
                $gt_notification = $this->notifications_insert(null, $gt_id, "Your Supervision Request has been Rejected by the Admin", 'approvalprocess_index');
                $this->auditLog('gt_approve_process', $update_id, 'Update', 'Rejected the Supervision Request', $userID, NOW(), 'Admin');
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
}
