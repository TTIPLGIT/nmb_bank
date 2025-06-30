<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\gtcriticalfileMail;
use App\Mail\gtapproveMail;
use App\Mail\gtcounselorapproveMail;
use App\Mail\gtrejectMail;
use App\Mail\gtselectedMail;
use App\Mail\gtrejectedMail;
use App\Mail\gtholdMail;
use App\Mail\gtrejectsupervisorMail;
use App\Mail\gtcriticalfileupdateMail;
use App\Mail\interviewscheduleMail;

class AssessmentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function professional()
    {
        try {
            $userID = auth()->user()->id;
            $method = 'Method => AssessmentController => professional';
            $rows = DB::select("SELECT *  from assessment_main inner join user_assessment on assessment_main.id = user_assessment.assessment_id where user_id='$userID' order by user_assessment.id");
            $data2 = DB::select("SELECT *  from professiona_technical_courses INNER JOIN assessment_main ON assessment_main.id=professiona_technical_courses.assesment_id where user_id='$userID'  order by assessment_main.id");
            $data3 = DB::select("SELECT count('id') as id  from elearning_userethnic where user_id = $userID and result='PASS'");
            $data4 = DB::select('SELECT title,description,route_url,type FROM assessment_main');
            if ($data3[0]->id != 0) {
                $exist = 1;
            } else {
                $exist = 0;
            }

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $rows;
            $serviceResponse['Data2'] = $data2;
            $serviceResponse['Data4'] = $data4;
            $serviceResponse['Data3'] = $exist;
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
    public function criticalapprove()

    {
        $method = 'Method => AssessmentController => professional';

        try {
            $userID = auth()->user()->id;
            //             $rows = DB::select("SELECT role_id,is_supervisor,user_id from gt_approve_process where approval_persons_id=$userID");
            //             $this->WriteFileLog($rows);
            //             $is_supervisor_id = $rows[0]->is_supervisor;
            // $this->WriteFileLog($is_supervisor_id);
            //             if ($is_supervisor_id == "2") {
            //                 $rows = DB::select("SELECT critical_analysis.id,users.name,critical_analysis.file_name,critical_analysis.status,critical_analysis.user_id,critical_analysis.counselor as active_status  from critical_analysis inner join users on users.id = critical_analysis.user_id inner join gt_approve_process on gt_approve_process.user_id=critical_analysis.user_id  where approval_persons_id='$userID' AND (counselor IS NULL OR counselor <> 1)");
            //             } else {
            //                 $rows = DB::select("SELECT critical_analysis.id,users.name,critical_analysis.file_name,critical_analysis.status,critical_analysis.user_id,critical_analysis.supervisor as active_status  from critical_analysis inner join users on users.id = critical_analysis.user_id inner join gt_approve_process on gt_approve_process.user_id=critical_analysis.user_id  where approval_persons_id='$userID'AND (supervisor IS NULL OR supervisor <> 1)");
            //             }
            // $notifications = DB::table('notifications')->insertGetId([
            //     'user_id' => auth()->user()->id,
            //     'notification_status' => 'Critical_analysis',
            //     'notification_url' => '/Professional/Competence',
            //     'megcontent' => 'Critical analysis File Approved Successfully',
            //     'alert_meg' => 'Critical analysis File Approved Successfully',
            //     'created_by' => auth()->user()->id,
            //     'created_at' => NOW()
            // ]);

            $rows = DB::select("SELECT ca.id,u.name,ca.file_name,ca.status,ca.user_id,ca.counselor,ca.supervisor from critical_analysis as ca inner join users as u on u.id = ca.user_id inner join gt_approve_process as gap on gap.user_id=ca.user_id where approval_persons_id='$userID'");
            $this->WriteFileLog($rows);
            $criticalData = [];
            foreach ($rows as $key => $row) {
                $data = DB::select("SELECT * from gt_approve_process where user_id = $row->user_id and approval_persons_id = $userID");
                $this->WriteFileLog($data);
                $active_status = null;
                if (count($data) !== 0) {
                    $this->WriteFileLog('jii');
                    if (count($data) !== 0 && $data[0]->is_supervisor == 1) {
                        $this->WriteFileLog('hii');
                        $active_status = $row->supervisor;
                    } else if (count($data) !== 0 && $data[0]->is_supervisor == 2) {
                        $this->WriteFileLog('kii');
                        $active_status = $row->counselor;
                    }
                }
                $row->active_status = $active_status;
                $criticalData[] = $row;
            }
            $this->WriteFileLog($criticalData);
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

    public function level(Request $request, $id)
    {
        try {
            $method = 'Method => AssessmentController => level';
            $userID = auth()->user()->id;
            $rows = DB::select("SELECT *  from assessment_main  where route_url='$id'");
            $data = DB::select("SELECT *  from assessment_main inner join user_assessment on assessment_main.id = user_assessment.assessment_id where user_id='$userID' and route_url = '$id' order by user_assessment.id");
            $data2 = DB::select("SELECT *  from professiona_technical_courses INNER JOIN assessment_main ON assessment_main.id=professiona_technical_courses.assesment_id where user_id='$userID'  order by assessment_main.id");
            // $data3 = DB::select('SELECT title,description,route_url FROM assessment_main ');


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $rows;
            $serviceResponse['Data2'] = $data;
            $serviceResponse['Data3'] = $data2;
            // $serviceResponse['Data4'] = $data3;
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
    public function final_approve(Request $request)
    {

        try {


            $method = 'Method => AssessmentController => final_approve';
            $userID = auth()->user()->id;
            $inputArray = $this->decryptData($request->requestData);
            $id = $inputArray['id'];
            $gt_id = $inputArray['id'];

            $rows['general'] = DB::select("SELECT * FROM user_general_details inner join gt on user_general_details.user_id=gt.user_id  inner join users as u on u.id=user_general_details.user_id where gt.user_id=$gt_id and user_general_details.active_flag='0';");
            $rows['education'] = DB::select("SELECT * FROM user_education_dip_details where user_id=$gt_id and active_flag='0'");
            $rows['work_experience'] = DB::select("select * from user_exp_wrq_details where user_id=$gt_id and user_exp_wrq_details.active_flag='0';");
            $rows['certification'] = DB::select("select * from user_exp_cert_details where user_id=$id and user_exp_cert_details.active_flag='0';");
            $rows['data3'] = DB::table('users as u')
                ->select('u.*', 'ur.*', 'gap.id', 'gap.user_id', 'gap.approval_persons_id', 'gap.approval_status', 'gap.status', 'gap.active_flag', 'gap.role_id', 'gap.is_supervisor')
                ->Join('gt_approve_process as gap', 'u.id', '=', 'gap.approval_persons_id')
                ->Join('uam_roles as ur', 'ur.role_id', '=', 'gap.role_id')
                ->where('gap.user_id', $id)
                ->get();

            $rows['data4'] = DB::select("SELECT file_name,user_id FROM critical_analysis where user_id= $id");

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
    public function interview_process(Request $request)
    {
        try {
            $method = 'Method => AssessmentController => interview_process';



            $rows = DB::select("SELECT interview.user_id,interview.status,interview.comments,interview.address,interview.scheduled_date,users.name FROM interview inner join users on users.id=interview.user_id where interview.active_flag=0 ORDER BY interview.scheduled_date DESC ");
            $rows2 = DB::select("SELECT *
            FROM users
            INNER JOIN critical_analysis ON users.id = critical_analysis.user_id
            WHERE critical_analysis.status = 3
            AND IF((SELECT COUNT(*) FROM interview WHERE user_id = users.id) > 0,
                   (SELECT status FROM interview WHERE user_id = users.id) NOT IN (2),
                   1);
            ");

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $rows;
            $serviceResponse['Data2'] = $rows2;
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


    public function critical_report()
    {
        try {
            $method = 'Method => AssessmentController => critical_report';
            $userID = auth()->user()->id;
            $rows = DB::select("SELECT *  from critical_analysis  where user_id='$userID'");
            $data3 = DB::select("SELECT count('id') as id  from elearning_userethnic where user_id = $userID and result='PASS'");
            if ($data3[0]->id != 0) {
                $exist = 1;
            } else {
                $exist = 0;
            }

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $rows;
            $serviceResponse['Data2'] = $exist;
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



    public function level_store(Request $request)
    {
        try {
            $method = 'Method => AssessmentController => level_store';
            $userID = auth()->user()->id;

            $inputArray = $this->decryptData($request->requestData);
            $wordCount = $inputArray['word_count'];
            $minimumWordCount = 150;
            $percentage = min(($wordCount / $minimumWordCount) * 100, 100);
            $input = [
                'valuer_comments' => $inputArray['valuer_comments'],
                'is_submitted' => $inputArray['is_submitted'],
                'assessment_id' => $inputArray['assessment_id'],
                'level' => $inputArray['level'],
                'word_count' => $percentage,
                'user_id' => $userID,

            ];
            $assessment_id = $input['assessment_id'];
            $user_id = $input['user_id'];
            $rows = DB::select("SELECT *  from user_assessment  where assessment_id =  $assessment_id and user_id =$user_id");
            $rows2 = DB::select("SELECT *  from assessment_main  where id =  $assessment_id ");

            $type = $rows2[0]->type;
            if ($rows == []) {
                DB::transaction(function () use ($input) {
                    $user_id = DB::table('user_assessment')
                        ->insertGetId([
                            'assessment_id' => $input['assessment_id'],
                            'notes' => $input['valuer_comments'],
                            'status' => '0',
                            'user_id' => $input['user_id'],
                            'is_submitted' => $input['is_submitted'],
                            'level' => $input['level'],
                            'percentage' => $input['word_count'],
                            'created_at' => NOW(),


                        ]);
                });
            } else {
                DB::transaction(function () use ($input) {
                    $user_id = DB::table('user_assessment')
                        ->where('user_id', $input['user_id']) // Assuming user_id is the primary key
                        ->where('assessment_id', $input['assessment_id']) // Assuming user_id is the primary key

                        ->update([

                            'notes' => $input['valuer_comments'],
                            'status' => '0',
                            'is_submitted' => $input['is_submitted'],
                            'level' => $input['level'],
                            'percentage' => $input['word_count'],
                            'updated_at' => NOW(),
                        ]);
                });
            }


            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Critical_analysis',
                'notification_url' => '/Professional/Competence',
                'megcontent' => 'The competency Submitted successfully',
                'alert_meg' => 'The competency Submitted successfully',
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('assessment_main', $user_id, 'Level', 'GT Created a Level', auth()->user()->id, NOW(), $role_name_fetch);



            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $type;
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
    public function critical_store(Request $request)
    {
        try {
            $method = 'Method => AssessmentController => critical_store';
            $userID = auth()->user()->id;

            $inputArray = $this->decryptData($request->requestData);
            $fileUpload = $inputArray['fileUpload'];

            $input = [
                'fileUpload' => $inputArray['fileUpload'],
                'user_id' => $userID,

            ];


            DB::transaction(function () use ($input) {
                $userID = DB::table('critical_analysis')
                    ->insertGetId([
                        'file_name' => $input['fileUpload'],
                        'user_id' => $input['user_id'],
                        'comments' => '-',
                    ]);
            });

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Critical_analysis',
                'notification_url' => '/Critical/Report',
                'megcontent' => 'Critical analysis file has been uploaded sucessfully.',
                'alert_meg' => 'Critical analysis file has been uploaded sucessfully.',
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            $gt_analysis = DB::select("SELECT * FROM gt_approve_process WHERE user_id=$userID");
            foreach ($gt_analysis as $key => $row) {
                $users = DB::select("SELECT name FROM users where id= '$userID';");
                $user_name = $users[0]->name;
                $name = $user_name . '(GT)';
                $approval_persons_id = $row->approval_persons_id;

                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => $approval_persons_id,
                    'notification_status' => 'Critical Approve',
                    'notification_url' => '/critical/approve',
                    'megcontent' => "$name is awaiting for your approval",
                    'alert_meg' => "$name is awaiting for your approval",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);

                $email = $this->getusermail($approval_persons_id);
                $name = $this->getusername($approval_persons_id);
                $base_url = config('setting.base_url');
                $gt_name   =  $user_name . '';
                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'gt_name' => $gt_name,
                    'base_url' => $base_url
                );
                Mail::to($data['email'])->send(new gtcriticalfileMail($data));
            }

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('critical_analysis', $userID, 'Upload', 'GT Upload the File', auth()->user()->id, NOW(), $role_name_fetch);


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
    public function approvegt(Request $request)
    {
        try {
            $method = 'Method => AssessmentController => approvegt';
            $userID = auth()->user()->id;

            $inputArray = $this->decryptData($request->requestData);
            $gt_id = $inputArray['gt_id'];

            $input = [
                'gt_id' => $inputArray['gt_id'],

            ];

            DB::transaction(function () use ($input) {
                $userID = DB::table('critical_analysis')
                    ->where('user_id', $input['gt_id'])
                    ->update([
                        'status' => '3',
                    ]);
            });


            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Critical_analysis',
                'notification_url' => '/Professional/Competence',
                'megcontent' => 'Approved GT Successfully',
                'alert_meg' => 'Approved GT Successfully',
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('critical_analysis', $userID, 'Approved', 'GT Final Assessment approved Successfully.', auth()->user()->id, NOW(), $role_name_fetch);


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
    public function interview_store(Request $request)
    {
        try {
            $method = 'Method => AssessmentController => interview_store';
            $userID = auth()->user()->id;
            $id = auth()->user()->id;
            $userID = auth()->user()->id;
            $inputArray = $this->decryptData($request->requestData);
            $gt_id = $inputArray['gt_id'];
            $now = NOW();
            $this->WriteFileLog($now);
            $userCheck = DB::select("SELECT id, created_at, DATE_ADD(created_at, INTERVAL 2 YEAR) AS two_years_later FROM 
                users WHERE id = $gt_id AND DATE_ADD(STR_TO_DATE(created_at, '%Y-%m-%d %H:%i:%s'), INTERVAL 2 YEAR) <='$now'");

            if ($userCheck == []) {

                $email = $this->getusermail($gt_id);
                $name = $this->getusername($gt_id);
                $base_url = config('setting.base_url');
                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'base_url' => $base_url
                );
                Mail::to($data['email'])->send(new interviewscheduleMail($data));


                $serviceResponse = [
                    'Code' => 400,
                    'Message' => config('setting.status_message.success'),
                    'Data' => 'interview.interview',
                ];
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                return $sendServiceResponse;
            }

            $input = [
                'gt_id' => $inputArray['gt_id'],
                'date' => $inputArray['date'],
                'address' => $inputArray['address'],


            ];
            DB::transaction(function () use ($input) {
                $user_id = DB::table('interview')
                    ->insertGetId([
                        'address' => $input['address'],
                        'user_id' => $input['gt_id'],
                        'scheduled_date' => $input['date'],
                    ]);

                $update_id = DB::table('gt')
                ->where('user_id', $input['gt_id'])
                    ->update([
                        'active_flag' => 0
                    ]);
            });


            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Critical_analysis',
                'notification_url' => '/interview/process',
                'megcontent' => 'Interview Scheduled for GT Successfully',
                'alert_meg' => 'Interview Scheduled for GT Successfully',
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => $input['gt_id'],
                'notification_status' => 'Critical_analysis',
                'notification_url' => '/interview/process',
                'megcontent' => 'Your Interview is Scheduled on'. $input['date'],
                'alert_meg' => 'Your Interview is Scheduled on'. $input['date'],
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('interview', $userID, 'Scheduled', 'Interview Scheduled for GT Successfully.', auth()->user()->id, NOW(), $role_name_fetch);


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
    public function interview_update(Request $request)
    {
        try {
            $method = 'Method => AssessmentController => interview_update';
            $userID = auth()->user()->id;

            $inputArray = $this->decryptData($request->requestData);
            $gt_id = $inputArray['gt_id'];

            $input = [
                'gt_id' => $inputArray['gt_id'],
                'date' => $inputArray['date'],
                'address' => $inputArray['address'],
            ];

            DB::transaction(function () use ($input) {
                DB::table('interview')
                    ->where('user_id', $input['gt_id'])
                    ->update([
                        'address' => $input['address'],
                        'scheduled_date' => $input['date'],
                    ]);
            });



            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Critical_analysis',
                'notification_url' => '/Professional/Competence',
                'megcontent' => 'Interview Updated for GT',
                'alert_meg' => 'Interview Updated for GT',
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

    public function interview_updatenew(Request $request)
    {

        try {
            $method = 'Method => AssessmentController => interview_updatenew';
            $userID = auth()->user()->id;

            $inputArray = $this->decryptData($request->requestData);
            $user_id = $inputArray['user_id'];
            $input = [
                'user_id' => $user_id,
                'status' => $inputArray['status'],
                'comments' => $inputArray['comments'],

            ];


            DB::transaction(function () use ($input) {
                DB::table('interview')
                    ->where('user_id', $input['user_id']) // Assuming user_id is the primary key
                    ->update([
                        'status' => $input['status'],

                    ]);
            });


            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Critical_analysis',
                'notification_url' => '/interview/process',
                'megcontent' => 'New Interview Schedule Updated for GT',
                'alert_meg' => 'New Interview Schedule Updated for GT',
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);




            $email = $this->getusermail($user_id);
            $name = $this->getusername($user_id);
            $base_url = config('setting.base_url');

            $data = array(
                'name' => $name,
                'email' => $email,
                'base_url' => $base_url
            );


            if ($inputArray['status'] == 1) {
                DB::table('users')
                    ->where('id', $user_id)
                    ->update([
                        'array_roles' => '34',
                    ]);

                $user_screen_id1 = DB::select("select * from uam_user_screens where user_id = '$user_id'");
                $screenidcount1 = count($user_screen_id1);
                for ($w = 0; $w < $screenidcount1; $w++) {
                    $uam_user_screen_permissions_id  =  $user_screen_id1[$w]->user_screen_id;
                    $delete_role_screen_id  = DB::table('uam_user_screen_permissions')->where('user_screen_id', $uam_user_screen_permissions_id)->delete();
                }
                $uam_modules_id =  DB::table('uam_user_roles')
                    ->where('user_id', $user_id)
                    ->delete();
                $uam_user_screens =  DB::table('uam_user_screens')
                    ->where('user_id', $user_id)
                    ->delete();

                $uam_screen_id = DB::table('uam_user_roles')->insertGetId([
                    'user_id' => $user_id,
                    'role_id' => '34',
                    'active_flag' => 0,
                    'created_by' => auth()->user()->id,
                    'created_date' => NOW()
                ]);


                $role_id = '34';
                $parentrow =  DB::select("select a.screen_id,a.module_screen_id,a.module_id from uam_role_screens as a where a.role_id = $role_id");
                $parentidcounting = count($parentrow);
                if ($parentrow != []) {
                    for ($j = 0; $j < $parentidcounting; $j++) {
                        $module_id = $parentrow[$j]->module_id;
                        $screen_id = $parentrow[$j]->screen_id;
                        $x = 0;
                        $modulesrows =  DB::select("select * from uam_modules where module_id = $module_id");
                        if ($modulesrows != []) {
                            $parent_module_id = $modulesrows[$x]->parent_module_id;
                            $module_name = $modulesrows[$x]->module_name;
                        }

                        $screenrows =  DB::select("select * from uam_screens where screen_id = $screen_id");
                        if ($screenrows != []) {
                            $screen_name = $screenrows[$x]->screen_name;
                            $screen_url = $screenrows[$x]->screen_url;
                            $route_url = $screenrows[$x]->route_url;
                            $class_name = $screenrows[$x]->class_name;
                            $display_order = $screenrows[$x]->display_order;
                        }

                        $check = DB::select("select * from uam_user_screens where module_id = $module_id and user_id = $user_id and screen_id = $screen_id ");
                        $checkcount = count($check);
                        if ($checkcount == '' || $checkcount != '') {
                            $screen_permission_id = DB::table('uam_user_screens')->insertGetId([
                                'screen_id' => $screen_id,
                                'module_id' => $module_id,
                                'parent_module_id' => $parent_module_id,
                                'module_name' => $module_name,
                                'screen_name' => $screen_name,
                                'screen_url' => $screen_url,
                                'route_url' => $route_url,
                                'class_name' => $class_name,
                                'display_order' => $display_order,
                                'user_id' => $user_id,
                                'active_flag' => 0,
                                'created_by' => auth()->user()->id,
                                'created_date' => NOW()
                            ]);
                        } else {
                        }
                    };
                };



                $checking = DB::select("select a.user_screen_id,a.screen_id,a.module_id from uam_user_screens as a where  a.user_id = $user_id ");
                $checkcounting = count($checking);
                if ($checking != []) {
                    for ($k = 0; $k < $checkcounting; $k++) {
                        $screen_id = $checking[$k]->screen_id;
                        $user_screen_id = $checking[$k]->user_screen_id;

                        $permissioncheck = DB::select("select a.*,b.array_permission from uam_screen_permissions as a
                            inner join uam_role_screen_permissions as b on b.screen_permission_id = a.screen_permission_id
                            where a.screen_id  = '$screen_id' and b.role_id = '$role_id'");

                        $permissioncheckcount = count($permissioncheck);
                        for ($m = 0; $m < $permissioncheckcount; $m++) {
                            $screen_permission_id = $permissioncheck[$m]->screen_permission_id;
                            $permission_name = $permissioncheck[$m]->permission;
                            $description = $permissioncheck[$m]->description;
                            $active_flag = $permissioncheck[$m]->active_flag;
                            $array_permission = $permissioncheck[$m]->array_permission;
                            $role_screen_permissions_id = DB::table('uam_user_screen_permissions')->insertGetId([
                                'user_screen_id' =>  $user_screen_id,
                                'screen_permission_id' =>  $screen_permission_id,
                                'permission' => $permission_name,
                                'description' => $description,
                                'active_flag' => $active_flag,
                                'array_permission' => $array_permission,
                                'user_id' => $user_id,
                                'created_by' => auth()->user()->id,
                                'created_date' => NOW()
                            ]);
                        };
                    };
                };




                Mail::to($data['email'])->send(new gtselectedMail($data));
            } elseif ($inputArray['status'] == 2) {
                Mail::to($data['email'])->send(new gtrejectedMail($data));
            } elseif ($inputArray['status'] == 3) {
                Mail::to($data['email'])->send(new gtholdMail($data));
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

    public function competency_fetch(Request $request)
    {


        try {
            $method = 'Method => AssessmentController => competency_fetch';
            $userID = auth()->user()->id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'category' => $inputArray['category'],
                'Competency' => $inputArray['Competency'],
                'user_id' => $userID,

            ];
            $id = $input['Competency'];
            $rows = DB::select("SELECT *  from assessment_main  where id =  $id");
            $response = [
                'rows' => $rows,
            ];

            // $notifications = DB::table('notifications')->insertGetId([
            //     'user_id' => auth()->user()->id,
            //     'notification_status' => 'Critical_analysis',
            //     'notification_url' => '/Professional/Competence',
            //     'megcontent' => 'Critical analysis File Upload',
            //     'alert_meg' => 'Critical analysis File Upload',
            //     'created_by' => auth()->user()->id,
            //     'created_at' => NOW()
            // ]);

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
    public function interview_fetch(Request $request)
    {

        try {
            $method = 'Method => AssessmentController => competency_fetch';
            $userID = auth()->user()->id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
                'type' => $inputArray['type'],
            ];
            $id = $input['id'];
            if ($inputArray['type'] == "edit") {
                $rows = DB::select("SELECT *  from interview inner join users on users.id = interview.user_id  where user_id =  $id");
            } elseif ($inputArray['type'] == "show")
                $rows = DB::select("SELECT *  from interview  where user_id =  $id");
            $response = [
                'rows' => $rows,
            ];

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('interview', $userID, 'Update', 'interview details updated Successfully.', auth()->user()->id, NOW(), $role_name_fetch);

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
    public function competency_store(Request $request)
    {


        try {
            $method = 'Method => AssessmentController => competency_fetch';
            $userID = auth()->user()->id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'category' => $inputArray['category'],
                'Competency' => $inputArray['Competency'],
                'user_id' => $userID,

            ];
            // $id=$input['Competency'];
            // $rows = DB::select("SELECT *  from assessment_main  where id =  $id");
            // $this->WriteFileLog($rows);
            // $response = [
            //     'rows' => $rows,
            // ];

            DB::transaction(function () use ($input) {
                $user_id = DB::table('professiona_technical_courses')
                    ->insertGetId([
                        'course_type' => $input['category'],
                        'assesment_id' => $input['Competency'],
                        'user_id' => $input['user_id'],
                        'created_by' => $input['user_id'],
                        'created_at' => NOW(),


                    ]);
            });

            // $notifications = DB::table('notifications')->insertGetId([
            //     'user_id' => auth()->user()->id,
            //     'notification_status' => 'Critical_analysis',
            //     'notification_url' => '/Professional/Competence',
            //     'megcontent' => 'Competency Saved Successfully',
            //     'alert_meg' => 'Competency Saved Successfully',
            //     'created_by' => auth()->user()->id,
            //     'created_at' => NOW()
            // ]);

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('assessment_main', $userID, 'Selected', 'GT Selected the Competency Successfully', auth()->user()->id, NOW(), $role_name_fetch);


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] =  1;
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
    public function critical_decision(Request $request)
    {


        try {
            $method = 'Method => AssessmentController => critical_decision';

            $userID = auth()->user()->id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
                'comment' => $inputArray['comment'],
                'status' => $inputArray['status'],
                'user_id' => $userID,
            ];
            $gt_critical_id =  $input['id'];
            $role_notify = DB::select("select * from critical_analysis Where id = $gt_critical_id");
            $gt_user_id = $role_notify[0]->user_id;
            $role_data = DB::select("SELECT role_id,is_supervisor,user_id from gt_approve_process where approval_persons_id=$userID and user_id=$gt_user_id");
            $is_supervisor = $role_data[0]->is_supervisor;
            if ($input['status'] == 1) {

                if ($is_supervisor == 1) {

                    DB::transaction(function () use ($input) {
                        $userID =  DB::table('critical_analysis')
                            ->where('id', $input['id'])
                            ->update([
                                'comments' => $input['comment'],
                                'status' => $input['status'],
                                'supervisor' => $input['status'],
                            ]);
                    });
                    $gt_critical_data = DB::select("SELECT * FROM critical_analysis WHERE id= $gt_critical_id");
                    $gt = $gt_critical_data[0]->user_id;
                    $professional_name = $this->getusername($userID);

                    if ($input['status'] == 1) {
                        $notifications = DB::table('notifications')->insertGetId([
                            'user_id' => auth()->user()->id,
                            'notification_status' => 'Critical_analysis',
                            'notification_url' => '/critical/approve',
                            'megcontent' => 'You approved Critical Report of Successfully ',
                            'alert_meg' => 'You approved Critical Report of Successfully',
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);

                        $notifications = DB::table('notifications')->insertGetId([
                            'user_id' => $role_notify[0]->user_id,
                            'notification_status' => 'Critical_analysis',
                            'notification_url' => '/critical/approve',
                            'megcontent' => "You approved by Professional Member $professional_name.",
                            'alert_meg' => "You approved by Professional Member $professional_name.",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);

                        $users = DB::select("SELECT name FROM users where id= '$userID';");
                        $user_name = $users[0]->name;
                        $name = $user_name . '(GT)';

                        $notifications = DB::table('notifications')->insertGetId([
                            'notification_status' => `Graduate Trainee is awaiting for your Approval.`,
                            'notification_url' => 'gtapprove',
                            'megcontent' => "$name is waiting for your Approval.",
                            'alert_meg' => "$name is waiting for your Approval.",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW(),
                            'role_id' => '30'
                        ]);


                        $gt_critical_data = DB::select("SELECT * FROM critical_analysis WHERE id= $gt_critical_id");
                        $gt = $gt_critical_data[0]->user_id;
                        $email = $this->getusermail($gt);
                        $name = $this->getusername($gt);
                        $base_url = config('setting.base_url');

                        $data = array(
                            'name' => $name,
                            'email' => $email,
                            'base_url' => $base_url
                        );

                        Mail::to($data['email'])->send(new gtapproveMail($data));

                        $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                        $role_name_fetch = $role_name[0]->role_name;
                        $this->auditLog('critical_analysis', $userID, 'Approved', 'File Approved by Professional Member For GT', auth()->user()->id, NOW(), $role_name_fetch);
                    } elseif ($input['status'] == 2) {


                        $notifications = DB::table('notifications')->insertGetId([
                            'user_id' => auth()->user()->id,
                            'notification_status' => 'Critical_analysis',
                            'notification_url' => '/critical/approve',
                            'megcontent' => 'You Rejected Critical Report of Successfully ',
                            'alert_meg' => 'You Rejected Critical Report of Successfully',
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                        $professional_name = $this->getusername($userID);
                        $notifications = DB::table('notifications')->insertGetId([
                            'user_id' => $role_notify[0]->user_id,
                            'notification_status' => 'Critical_analysis',
                            'notification_url' => '/Critical/Report',
                            'megcontent' => "You Rejected by Professional Member $professional_name.",
                            'alert_meg' => "You Rejected by Professional Member $professional_name.",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);

                        $gt_critical_id =  $input['id'];
                        $gt_critical_data = DB::select("SELECT * FROM critical_analysis WHERE id= $gt_critical_id");
                        $gt = $gt_critical_data[0]->user_id;

                        $email = $this->getusermail($gt);
                        $name = $this->getusername($gt);
                        $base_url = config('setting.base_url');

                        $data = array(
                            'name' => $name,
                            'email' => $email,
                            'base_url' => $base_url
                        );
                        Mail::to($data['email'])->send(new gtrejectMail($data));
                    }
                    $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                    $role_name_fetch = $role_name[0]->role_name;
                    $this->auditLog('critical_analysis', $userID, 'Rejected', 'File Rejected by Professional Member For GT', auth()->user()->id, NOW(), $role_name_fetch);
                } else {
                    DB::transaction(function () use ($input) {
                        $userID =  DB::table('critical_analysis')
                            ->where('id', $input['id'])
                            ->update([
                                'comments' => $input['comment'],
                                'status' => $input['status'],
                                'counselor' => $input['status'],
                            ]);
                    });
                    $gt_critical_id =  $input['id'];

                    $gt_critical_data = DB::select("SELECT * FROM critical_analysis WHERE id= $gt_critical_id");
                    $gt = $gt_critical_data[0]->user_id;
                    $professional_name = $this->getusername($userID);

                    $notifications = DB::table('notifications')->insertGetId([
                        'user_id' => auth()->user()->id,
                        'notification_status' => 'Critical_analysis',
                        'notification_url' => '/critical/approve',
                        'megcontent' => 'You approved Critical Report of Successfully ',
                        'alert_meg' => 'You approved Critical Report of Successfully',
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);

                    $notifications = DB::table('notifications')->insertGetId([
                        'user_id' => $role_notify[0]->user_id,
                        'notification_status' => 'Critical_analysis',
                        'notification_url' => '/critical/approve',
                        'megcontent' => "You approved by Professional Member $professional_name.",
                        'alert_meg' => "You approved by Professional Member $professional_name .",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                }

                $email = $this->getusermail($gt);
                $name = $this->getusername($gt);
                $base_url = config('setting.base_url');
                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'base_url' => $base_url
                );

                $this->WriteFileLog($data);
                Mail::to($data['email'])->send(new gtcounselorapproveMail($data));
                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                $role_name_fetch = $role_name[0]->role_name;
                $this->auditLog('critical_analysis', $userID, 'Approved', 'File Approved by Professional Member For GT', auth()->user()->id, NOW(), $role_name_fetch);
            } else {
                if ($is_supervisor == 1) {
                    DB::transaction(function () use ($input) {
                        DB::table('critical_analysis')
                            ->where('id', $input['id'])
                            ->update([
                                'comments' => $input['comment'],
                                'status' => $input['status'],
                                'supervisor' => $input['status'],
                                'counselor' => $input['status'],
                            ]);
                    });

                    $notifications = DB::table('notifications')->insertGetId([
                        'user_id' => auth()->user()->id,
                        'notification_status' => 'Critical_analysis',
                        'notification_url' => '/critical/approve',
                        'megcontent' => 'You Rejected Critical Report of Successfully ',
                        'alert_meg' => 'You Rejected Critical Report of Successfully',
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                } else {
                    DB::transaction(function () use ($input) {
                        DB::table('critical_analysis')
                            ->where('id', $input['id'])
                            ->update([
                                'comments' => $input['comment'],
                                'status' => $input['status'],
                                'supervisor' => $input['status'],
                                'counselor' => $input['status'],
                            ]);
                    });


                    $notifications = DB::table('notifications')->insertGetId([
                        'user_id' => auth()->user()->id,
                        'notification_status' => 'Critical_analysis',
                        'notification_url' => '/critical/approve',
                        'megcontent' => 'You Rejected Critical Report of Successfully ',
                        'alert_meg' => 'You Rejected Critical Report of Successfully',
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    $professional_name = $this->getusername($userID);
                    $notifications = DB::table('notifications')->insertGetId([
                        'user_id' => $role_notify[0]->user_id,
                        'notification_status' => 'Critical_analysis',
                        'notification_url' => '/critical/approve',
                        'megcontent' => "You Rejected by Professional Member $professional_name.",
                        'alert_meg' => "You Rejected by Professional Member $professional_name.",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);

                    $gt_critical_id =  $input['id'];

                    $gt_critical_data = DB::select("SELECT * FROM critical_analysis WHERE id= $gt_critical_id");
                    $gt = $gt_critical_data[0]->user_id;

                    $email = $this->getusermail($gt);
                    $name = $this->getusername($gt);
                    $base_url = config('setting.base_url');

                    $data = array(
                        'name' => $name,
                        'email' => $email,
                        'base_url' => $base_url
                    );


                    Mail::to($data['email'])->send(new gtrejectsupervisorMail($data));
                }
                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                $role_name_fetch = $role_name[0]->role_name;
                $this->auditLog('critical_analysis', $userID, 'Rejected', 'File Rejected by Professional Member For GT', auth()->user()->id, NOW(), $role_name_fetch);
            }



            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] =  1;
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
    public function final_assesment(Request $request)
    {

        try {
            $method = 'Method => AssessmentController => competency_fetch';
            $userID = auth()->user()->id;
            $rows = DB::select("SELECT distinct critical_analysis.status,users.name,gt.interest,users.country,critical_analysis.user_id as id  from critical_analysis inner join gt on gt.user_id=critical_analysis.user_id inner join user_general_details on user_general_details.user_id = critical_analysis.user_id inner join users on users.id = critical_analysis.user_id   where counselor = 1 and supervisor =1 and critical_analysis.status !=0");


            // $id=$input['Competency'];
            // $rows = DB::select("SELECT *  from assessment_main  where id =  $id");
            // $response = [
            //     'rows' => $rows,
            // ];


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] =  $rows;
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


    public function critical_analysis()
    {
        try {
            $method = 'Method => AssessmentController => critical_analysis';

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


    public function criticalfile_update(Request $request)
    {
        try {

            $userID = auth()->user()->id;

            $method = 'Method => AssessmentController => criticalfile_update';
            $inputArray = $request->requestData;
            $inputArray = $this->decryptData($inputArray);
            $input = [
                'fileUpload_name' => $inputArray['fileUpload_name'],
                'user_id' => $userID,
            ];
            $update_id =  DB::table('critical_analysis')
                ->where([['user_id', $input['user_id']]])
                ->update([

                    'file_name' => $input['fileUpload_name'],
                    'status' => '0',

                ]);



            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Critical_analysis',
                'notification_url' => '/critical/approve',
                'megcontent' => 'Critical analysis File Updated Successfully',
                'alert_meg' => 'Critical analysis File Updated Successfully',
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            $gt_analysis = DB::select("SELECT * FROM gt_approve_process WHERE user_id=$userID");
            foreach ($gt_analysis as $key => $row) {
                $users = DB::select("SELECT name FROM users where id= '$userID';");
                $user_name = $users[0]->name;
                $name = $user_name . '(GT)';
                $approval_persons_id = $row->approval_persons_id;

                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => $approval_persons_id,
                    'notification_status' => 'Critical Approve',
                    'notification_url' => '/critical/approve',
                    'megcontent' => "$name Reupload the critical Analysis file and is awaiting for your approval",
                    'alert_meg' => "$name Reupload the critical Analysis file and is awaiting for your approval",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);

                $email = $this->getusermail($approval_persons_id);
                $name = $this->getusername($approval_persons_id);
                $base_url = config('setting.base_url');
                $gt_name   =  $user_name . '';
                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'gt_name' => $gt_name,
                    'base_url' => $base_url
                );
                Mail::to($data['email'])->send(new gtcriticalfileupdateMail($data));
            }


            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('critical_analysis', $update_id, 'File Update', 'File Updated by GT', auth()->user()->id, NOW(), $role_name_fetch);



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

    public function interview_delete(Request $request)
    {
        try {
            $method = 'Method => LocalAdoptationTestController => update';
            $inputArray = $this->decryptData($request->requestData);
            $this->WriteFileLog($inputArray);
            $input = [
                'user_id' => $inputArray['user_id'],

            ];
            $id = $input['user_id'];

            $update_id = DB::table('interview')
                ->where('user_id', $id)
                ->update([

                    'active_flag' => '1',

                ]);
            $message = "Interview Schedule Data Deleted Successfully";

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' =>  auth()->user()->id,
                'notification_status' => 'Interview',
                'notification_url' => '/interview/process',
                'megcontent' => "Interview Details Deleted Successfully",
                'alert_meg' =>  "Interview Details Deleted Successfully",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('interview', $update_id, 'Delete', 'Interview Details Deleted Successfully', auth()->user()->id, NOW(), $role_name_fetch);



            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 1;
            $serviceResponse['response_message'] = $message;
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



    public function professional_show(Request $request)
    {

        try {
            $method = 'Method => AssessmentController => professional_show';
            $userID = auth()->user()->id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'user_id' => $inputArray['user_id'],
                'type' => $inputArray['type'],
            ];
            $userID = $input['user_id'];
            if ($inputArray['type'] == "show") {
                $rows = DB::select("SELECT comments FROM critical_analysis WHERE user_id = $userID AND active_flag = '0';");
            }
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


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

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
}