<?php

namespace App\Http\Controllers;

use App\Mail\gtselectedMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Mail\localadaptationmail; 

class LocalAdoptationTestController extends BaseController
{
    public function index(Request $request)
    {
        try {

            $method = 'Method => LocalAdoptationTestController => index';
            $rows['quiz_dropdown'] = DB::select('SELECT q.* from elearning_practice_quiz  AS q left join elearning_ethnictest AS e ON q.quiz_id=e.quiz_id left join elearning_exam AS el ON q.quiz_id=el.quiz_id left join elearning_classes AS ec ON q.quiz_id=ec.quiz_id WHERE e.quiz_id IS NULL and el.quiz_id IS NULL and ec.quiz_id IS NULL AND q.drop_quiz=0');
            $rows['user_category'] = array(
                'Professional Member(NRU)' => config('setting.roles.Professional Member(NRU)'),

            );


            $rows['quiz_list'] = DB::select('SELECT et.id,et.user_category,ur.role_name,et.adapttest_name,et.quiz_id,et.pass_percentage,eq.quiz_name from elearning_localadaptation as et inner join elearning_practice_quiz as eq  on eq.quiz_id = et.quiz_id INNER JOIN uam_roles AS ur ON ur.role_id = et.user_category where et.active_flag=0');


            $response = [
                'rows' => $rows
            ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;

            //code...
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

    public function store(Request $request)
    {
        try {
            $method = 'Method => LocalAdoptationTestController => store';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'user_category' => $inputArray['user_category'],
                'adapttest_name' => $inputArray['adapttest_name'],
                'quiz_id' => $inputArray['quiz_id'],
                'pass_percentage' => $inputArray['pass_percentage'],

            ];
            $update_id = DB::transaction(function () use ($input) {
                $settings_id = DB::table('elearning_localadaptation')
                    ->insertGetId([
                        'user_category' => $input['user_category'],
                        'adapttest_name' => $input['adapttest_name'],
                        'quiz_id' => $input['quiz_id'],
                        'pass_percentage' => $input['pass_percentage'],
                        'active_flag' => '0',
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
            });

            $this->notifications_insert(null, auth()->user()->id, "Local Adaptation Created Successfully", "/localadaptationtest");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_localadaptation', $update_id, 'Create', 'Local Adaptation Creation', auth()->user()->id, NOW(), $role_name_fetch);


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

    public function show(Request $request)
    {

        $method = 'Method => LocalAdoptationTestController => show';
        try {

            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $id = $request->id;
            $row = DB::table('elearning_localadaptation')
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

    public function edit($id)
    {
        try {
            $method = 'Method => LocalAdoptationTestController =>edit';
            $id = $this->decryptData($id);
            $row = DB::table('elearning_localadaptation')
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
    
    public function update(Request $request)
    {
        //

        try {
            $method = 'Method => LocalAdoptationTestController => update';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'user_category' => $inputArray['user_category'],
                'adapttest_name' => $inputArray['adapttest_name'],
                'quiz_id' => $inputArray['quiz_id'],
                'pass_percentage' => $inputArray['pass_percentage'],
                'eid' => $inputArray['eid'],

            ];

            $update_id = DB::table('elearning_localadaptation')
                ->where('id', $input['eid'])
                ->update([
                    'user_category' => $input['user_category'],
                    'adapttest_name' => $input['adapttest_name'],
                    'quiz_id' => $input['quiz_id'],
                    'pass_percentage' => $input['pass_percentage'],
                    'active_flag' => '0',
                    'updated_by' => auth()->user()->id,
                    'updated_at' => NOW()

                ]);
            $this->notifications_insert(null, auth()->user()->id, "Local Adaptation Updated Successfully", "/localadaptationtest");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_localadaptation', $update_id, 'Update', 'Local Adaptation Updation', auth()->user()->id, NOW(), $role_name_fetch);

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
    public function fetch(Request $request)
    {

        try {
            $method = 'Method => LocalAdoptationTestController =>fetch';
            $userID = auth()->user()->id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
            ];
            $id = $input['id'];
            $rows = DB::select("SELECT *  from elearning_localadaptation  where id =  $id");
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


    public function delete(Request $request)
    {
        try {
            $method = 'Method => LocalAdoptationTestController => update';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
            ];

            $update_id = DB::table('elearning_localadaptation')
                ->where('id', $input['id'])
                ->update([
                    'active_flag' => '1',
                ]);

            $this->notifications_insert(null, auth()->user()->id, "Local Adaptation Deleted Successfully", "/localadaptationtest");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_localadaptation', $update_id, 'Delete', 'Local Adaptation Deletion', auth()->user()->id, NOW(), $role_name_fetch);


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
    public function list(Request $request)
    {
        try {
            $userID = auth()->user()->id;
            $method = 'Method => LocalAdoptationTestController => list';
            $rows = DB::select("SELECT role_id from uam_user_roles  where user_id=$userID");
            $role_id = $rows[0]->role_id;
            $rows = DB::select("SELECT * FROM elearning_localadaptation WHERE user_category= $role_id and active_flag=0");
            if ($rows == []) {
                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.success');
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 0;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                return $sendServiceResponse;
            }


            $rows = DB::select("SELECT * FROM elearning_userlocaladaptation WHERE user_id=$userID");


            $response = [
                'rows' => $rows
            ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;

            //code...
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
    public function quiz()
    {
        try {
            $method = 'Method => LocalAdoptationTestController =>quiz';
            $userID = auth()->user()->id;
            $rows = DB::select("SELECT role_id from uam_user_roles  where user_id=$userID");
            $role_id = $rows[0]->role_id;

            $maxId = DB::select("SELECT id from elearning_localadaptation where user_category = $role_id and active_flag=0 order by id desc limit 0,1");
            $max = $maxId[0]->id;
            $availableQuizzes = DB::select("SELECT id from elearning_localadaptation where user_category =$role_id and active_flag=0");
            $availableQuizIds = [];
            foreach ($availableQuizzes as $availableQuiz) {
                array_splice($availableQuizIds, 1, 0, $availableQuiz->id);
            }
            do {
                $randomNumber = rand(1, $max);
            } while (!(in_array($randomNumber, $availableQuizIds)));
            $random_quizid = DB::select("Select quiz_id from elearning_localadaptation where id=$randomNumber");
            $random_quizid = $random_quizid[0]->quiz_id;
            $randomQuiz = DB::select("Select * from elearning_practice_quiz where quiz_id= $random_quizid");
            // $randomQuiz = DB::select("select * from elearning_localadaptation inner join elearning_practice_quiz on elearning_practice_quiz.quiz_id = elearning_localadaptation.quiz_id  where elearning_localadaptation.quiz_id=$randomNumber");

            $quizName = $randomQuiz[0]->quiz_name;
            $quizId = $randomQuiz[0]->quiz_id;
            $questions = explode(",", $randomQuiz[0]->quiz_questions);
            $questionDetails = [];
            $index = 0;
            foreach ($questions as $question) {
                $questionDetail = explode("-", $question);
                $questionId = $questionDetail[0];
                $questionType = $questionDetail[1];
                if ($questionType == "boolean") {
                    $questionDetails[$index] = DB::select("select * from elearning_questions_true_false where question_id=$questionId")[0];
                } elseif ($questionType == "mcq") {
                    $questionDetails[$index] = DB::select("select * from elearning_questions_mcq where question_id=$questionId")[0];
                    $choices = explode(",", $questionDetails[$index]->choices);
                    $questionDetails[$index]->choices = $choices;
                } elseif ($questionType == "short") {
                    $questionDetails[$index] = DB::select("select * from elearning_questions_short_answer where question_id=$questionId")[0];
                } elseif ($questionType == "long") {
                    $questionDetails[$index] = DB::select("select * from elearning_questions_long_answer where question_id=$questionId")[0];
                }
                $index++;
            }

            // for result valuation
            $qIds = $randomQuiz[0]->quiz_questions;
            $response = [
                'quizId' => $quizId,
                'quizName' => $quizName,
                'questionDetails' => $questionDetails,
                'qIds' => $qIds,

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
            // $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
    public function quizstore(Request $request)
    {


        try {
            $method = 'Method => LocalAdoptationTestController => quizstore';
            $user_id = auth()->user()->id;
            $inputArray = $this->decryptData($request->requestData);
            $maxId = DB::select("select quiz_id from elearning_localadaptation order by quiz_id desc limit 0,1");
            $max = $maxId[0]->quiz_id;
            $availableQuizzes = DB::select("select quiz_id from elearning_localadaptation where active_flag=0");
            $availableQuizIds = [];
            foreach ($availableQuizzes as $availableQuiz) {
                array_splice($availableQuizIds, 1, 0, $availableQuiz->quiz_id);
            }
            do {
                $randomNumber = rand(1, $max);
            } while (!(in_array($randomNumber, $availableQuizIds)));
            $randomQuiz = DB::select("select * from elearning_localadaptation inner join elearning_practice_quiz on elearning_practice_quiz.quiz_id = elearning_localadaptation.quiz_id  where elearning_localadaptation.quiz_id=$randomNumber");

            $quizId = $randomQuiz[0]->quiz_id;
            $pass_percentage =  $randomQuiz[0]->pass_percentage;
            $attempt = DB::select("SELECT count('id') as count from elearning_userlocaladaptation where user_id=$user_id");

            $previousattemptcount = $attempt[0]->count;
            $attemptcount = $previousattemptcount + 1;
            $totalpoints = DB::select("SELECT points from elearning_practice_quiz where quiz_id=$quizId");
            $totalpoints = $totalpoints[0]->points;
            $calc = ($pass_percentage / 100) * intval($totalpoints);

            $passmark = 30;
            if ($inputArray['score'] >= $calc) {
                $result = "PASS";
            } else {
                $result = "FAIL";
            }

            $input = [
                'quiz_id' => $quizId,
                'attempt' =>  $attemptcount,
                'score' => $inputArray['score'],
                'pass_mark' => $calc,
                'total_scores' => $inputArray['total_scores'],
                'result' =>  $result,

            ];


            $update_id = DB::transaction(function () use ($input, $user_id) {
                $settings_id = DB::table('elearning_userlocaladaptation')
                    ->insertGetId([
                        'quiz_id' => $input['quiz_id'],
                        'attempt' => $input['attempt'],
                        'score' => $input['score'],
                        'pass_mark' => $input['pass_mark'],
                        'total_scores' => $input['total_scores'],
                        'result' => $input['result'],
                        'user_id' => auth()->user()->id,
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);

                if ($input['result'] == "PASS") {
                    DB::table('users')
                        ->where('id', $user_id)
                        ->update([
                            'array_roles' => '34',
                            'from' => 'NUR',
                            'total_cptpoints' => '20'
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
                    $this->WriteFileLog("3");
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
                }
            });
            if ($input['result'] == "PASS") {
                $calc = 200;
                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => auth()->user()->id,
                    'notification_status' => 'Local Adoptation',
                    'notification_url' => '/',
                    'megcontent' => 'Congradulation You have completed the Local Adaptation Test',
                    'alert_meg' => 'Congradulation You have completed the Local Adaptation Test',
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);
            } else {
                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => auth()->user()->id,
                    'notification_status' => 'Local Adaptation',
                    'notification_url' => '/localadaptation/quiz/list',
                    'megcontent' => 'Thank You for the Attending test. Plese view the Result',
                    'alert_meg' => 'Thank You for the Attending test. Plese view the Result',
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);
            }

            $this->notifications_insert(null, auth()->user()->id, "Local Adaptation Test Attended successfully" . "Score:" . $input['score'], "/localadaptation/quiz/list");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            // $this->auditLog('elearning_userlocaladaptation', $update_id, 'Test Attended', 'Local Adaptation Test Attended', auth()->user()->id, NOW(), $role_name_fetch);

            $email = $this->getusermail($user_id);
            $name = $this->getusername($user_id);
            $base_url = config('setting.base_url');

            $data = array(
                'name' => $name,
                'email' => $email,
                'score' => $input['score'],
                'base_url' => $base_url
            );
            Mail::to($data['email'])->send(new gtselectedMail($data));
            Mail::to($data['email'])->send(new localadaptationmail($data));
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $calc;
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
