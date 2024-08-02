<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\If_;
use Illuminate\Support\Facades\Mail;
use App\Mail\nruapprovemail;
use App\Mail\nruregistrarrejectMail;

class nrvController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $logMethod = 'Method => nrvController => User';
        try {
            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $role = DB::select("select role_id from uam_user_roles where user_id=$userID");
            $role = $role[0]->role_id;

            $rows = array();
            $rows['rows'] = DB::table('approved_certificate')
                ->select('users.name as name', 'users.country as country', 'approved_certificate.status as status', 'approved_certificate.user_id as user_id', 'approved_certificate.comments as comments')
                ->join('users', 'users.id', '=', 'approved_certificate.user_id')
                ->orderByDesc('approved_certificate.id') // Replace 'id' with your primary key column name
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $method = 'Method => nrvController => data_edit';
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


    public function approvescreen_update(Request $request)
    {

        try {

            $method = 'Method => nrvController => updatedata';
            $inputArray = $request->requestData;
            $inputArray = $this->decryptData($inputArray);
            $userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];
            $input = [
                'gt_id' => $inputArray['gt_id'],
                'status' =>  $inputArray['status'],
                'messages' => $inputArray['messages']
            ];
            DB::transaction(function () use ($input) {
                $update_id =  DB::table('approved_certificate')
                    ->where([['user_id', $input['gt_id']]])
                    ->update([
                        'status' => $input['status'],
                        'comments' => $input['messages'],
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
        
            Mail::to($data['email'])->send(new nruapprovemail($data));


            $gt_id = intval($input['gt_id']);
            if ($input['status'] == 1) {

                $role_id = DB::table('uam_user_screens')
                    ->insertGetId([
                        'user_id' => $gt_id,
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

                    $gt_id=$input['gt_id'];
                    $users = DB::select("SELECT name FROM users where id= '$gt_id';");
                    $user_name = $users[0]->name;
                    $name = $user_name . '(NUR)';
                    // notication for supervisor
                    $notifications = DB::table('notifications')->insertGetId([
    
                        'user_id' => $gt_id,
                        'notification_status' => 'Registrar Approved NRV',
                        'notification_url' => 'approve_nrv',
                        'megcontent' => "Dear $name you has been approved by registrar successfully.",
                        'alert_meg' => "Dear $name you has been approved by registrar successfully.",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);



                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => $userID,
                    'notification_status' => 'Registrar Approved NRV',
                    'notification_url' => 'nrv_approval',
                    'megcontent' => "Approved the NRU Sucessfully.",
                    'alert_meg' => "Approved the NRU Sucessfully.",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);
            } else {

                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => $userID,
                    'notification_status' => 'Registrar Rejected NRV',
                    'notification_url' => 'nrv_approval',
                    'megcontent' => "Rejected the NRU Sucessfully.",
                    'alert_meg' => "Rejected the NRU Sucessfully.",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);

                $gt_id=$input['gt_id'];
                    $users = DB::select("SELECT name FROM users where id= '$gt_id';");
                    $user_name = $users[0]->name;
                    $name = $user_name . '(NUR)';
                    // notication for supervisor
                    $notifications = DB::table('notifications')->insertGetId([
    
                        'role_id' => config('setting.roles.Professional Member(NRU)'),
                        'user_id' => $userID,
                        'notification_status' => 'Registrar Rejected NRV',
                        'notification_url' => 'nrv_approval',
                        'megcontent' => "Dear $name you has been rejected by registrar successfully.",
                        'alert_meg' => "Dear $name you has been rejected by registrar successfully.",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);


                $email = $this->getusermail($input['gt_id']);
                $name = $this->getusername($input['gt_id']);
                $base_url = config('setting.base_url');

                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'base_url' => $base_url

                );

                Mail::to($data['email'])->send(new nruregistrarrejectMail($data));
            }



            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $input['status'];
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






    // public function rejectupdate(Request $request)
    // {


    //     try {

    //         $method = 'Method => gtapproveController => storedata';
    //         $inputArray = $request->requestData;
    //         $inputArray = $this->decryptData($inputArray);

    //         $userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];
    //         $userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];
    //         $role = DB::select("select role_id from uam_user_roles where user_id=$userID");
    //         $role = $role[0]->role_id;
    //         $input = [
    //             'gt_id' => $inputArray['gt_id'],
    //             'user_id' => $userID,

    //         ];

    //         DB::transaction(function () use ($input) {
    //             $update_id =  DB::table('gt_approve_process')
    //                 ->where([['approval_persons_id',  $input['user_id']]])
    //                 ->where([['user_id', $input['gt_id']]])
    //                 ->update([
    //                     'status' => 2,
    //                     'approval_status' => 'Rejected',

    //                 ]);
    //         });




    //         if ($role == '29') {
    //             $notifications = DB::table('notifications')->insertGetId([
    //                 'user_id' => $input['gt_id'],
    //                 'notification_status' => 'Counselor Rejected GT ',
    //                 'notification_url' => 'approvalprocess_index',
    //                 'megcontent' => "You have been Rejected Sucessfully by Counselor.",
    //                 'alert_meg' => "You have been Rejected Sucessfully by Counselor.",
    //                 'created_by' => auth()->user()->id,
    //                 'created_at' => NOW()
    //             ]);
    //         } else {
    //             $notifications = DB::table('notifications')->insertGetId([
    //                 'user_id' => $input['gt_id'],
    //                 'notification_status' => 'Supervisor Rejected GT',
    //                 'notification_url' => 'approvalprocess_index',
    //                 'megcontent' => "You have been Rejected Sucessfully by Supervisor.",
    //                 'alert_meg' => "You have been Rejected Sucessfully by Supervisor.",
    //                 'created_by' => auth()->user()->id,
    //                 'created_at' => NOW()
    //             ]);
    //         }




    //         if ($role == '28') {
    //             $message = "Supervisor";
    //         }
    //         if ($role == '29') {
    //             $message = "Counselor";
    //         }
    //         $notifications = DB::table('notifications')->insertGetId([
    //             'user_id' => auth()->user()->id,
    //             'notification_status' => `$message Rejected GT`,
    //             'notification_url' => 'gtapprove',
    //             'megcontent' => "Rejected the Graduate Trainee Successfully.",
    //             'alert_meg' => "Rejected the Graduate Trainee Successfully.",
    //             'created_by' => auth()->user()->id,
    //             'created_at' => NOW()

    //         ]);


    //         $serviceResponse = array();
    //         $serviceResponse['Code'] = config('setting.status_code.success');
    //         $serviceResponse['Message'] = config('setting.status_message.success');
    //         $serviceResponse['Data'] = 1;
    //         $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
    //         $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
    //         return $sendServiceResponse;
    //     } catch (\Exception $exc) {
    //         $exceptionResponse = array();
    //         $exceptionResponse['ServiceMethod'] = $method;
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    public function approve_screen(Request $request)
    {


        try {

            $method = 'Method => AssessmentController => professional';
            $userID = auth()->user()->id;
            $inputArray = $this->decryptData($request->requestData);
            $gt_id = $inputArray['id'];


            //for valuer approve (valers list)

            $method = 'Method => ajaxController => index';
            $rows['general'] = DB::select("SELECT * FROM user_general_details inner join gt on user_general_details.user_id=gt.user_id  inner join users as u on u.id=user_general_details.user_id where gt.user_id=$gt_id and user_general_details.active_flag='0';");
            $rows['education'] = DB::select("SELECT * FROM user_education_dip_details where user_id=$gt_id and active_flag='0'");
            $rows['work_experience'] = DB::select("select * from user_exp_wrq_details where user_id=$gt_id and user_exp_wrq_details.active_flag='0';");


            $rows['certification'] = DB::select("select * from user_exp_cert_details where user_id=$gt_id    and user_exp_cert_details.active_flag='0';");

            $rows['messages'] = DB::select("SELECT * FROM messages AS m INNER JOIN users ON m.gt_approval_persons_id=users.id inner join uam_user_roles as ur on ur.user_id= m.gt_approval_persons_id  WHERE gt_id=$gt_id");
            $rows['messages'] = DB::select("SELECT * FROM messages AS m INNER JOIN users ON m.gt_approval_persons_id=users.id inner join uam_user_roles as ur on ur.user_id= m.gt_approval_persons_id  WHERE gt_id=$gt_id");

            $rows['approved_certification'] = DB::select("SELECT * FROM approved_certificate WHERE user_id = $gt_id");
    
            $rows['data3'] = DB::table('users')
                ->select('*')
                ->Join('gt_approve_process', 'users.id', '=', 'gt_approve_process.approval_persons_id')
                ->Join('uam_roles', 'uam_roles.role_id', '=', 'gt_approve_process.role_id')
                ->where('gt_approve_process.user_id', $gt_id)
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
}
