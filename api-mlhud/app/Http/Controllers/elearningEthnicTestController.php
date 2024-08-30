<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Mail\ethictestmail;
use App\Mail\cptmail;
use App\Mail\exammail;
use App\Mail\exammail2;

use App\Mail\coursecertificate;

class elearningEthnicTestController extends BaseController
{
    public function index(Request $request)
    {
        try {
            $method = 'Method => elearningEthnicTestController => index';
            $rows['quiz_dropdown'] = DB::select('SELECT e.* from elearning_practice_quiz  AS e left join elearning_localadaptation AS l ON e.quiz_id=l.quiz_id left join elearning_exam AS el ON e.quiz_id=el.quiz_id left join elearning_classes AS ec ON e.quiz_id=ec.quiz_id WHERE l.quiz_id IS NULL and el.quiz_id IS NULL and ec.quiz_id IS NULL AND e.drop_quiz=0');
            $rows['user_category'] = array(
                'Student' => config('setting.roles.Student'),
                'Teacher' => config('setting.roles.Teacher'),
                'All' => 0
            );


            $rows['quiz_list'] = DB::select('SELECT et.id,et.user_category,ur.role_name,et.ethnictest_name,et.quiz_id,et.pass_percentage,eq.quiz_name from elearning_ethnictest as et inner join elearning_practice_quiz as eq  on eq.quiz_id = et.quiz_id INNER JOIN uam_roles AS ur ON ur.role_id = et.user_category where et.active_flag=0');


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
            $this->WriteFileLog($exceptionResponse);
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
    public function create(Request $request, $id)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $method = 'Method => elearningEthnicTestController => store';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'user_category' => $inputArray['user_category'],
                'ethnictest_name' => $inputArray['ethnictest_name'],
                'quiz_id' => $inputArray['quiz_id'],
                'pass_percentage' => $inputArray['pass_percentage'],

            ];
            $update_id = DB::transaction(function () use ($input) {
                $settings_id = DB::table('elearning_ethnictest')
                    ->insertGetId([
                        'user_category' => $input['user_category'],
                        'ethnictest_name' => $input['ethnictest_name'],
                        'quiz_id' => $input['quiz_id'],
                        'pass_percentage' => $input['pass_percentage'],
                        'active_flag' => '0',
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
            });

            $this->notifications_insert(null, auth()->user()->id, "Ethic Test Created Successfully", "/ethictest");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_ethnictest', $update_id, 'Create', 'Create Ethic Test', auth()->user()->id, NOW(), $role_name_fetch);

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

        $method = 'Method => elearningEthnicTestController => show';
        try {

            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $id = $request->id;
            $row = DB::table('elearning_ethnictest')
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





    /**
     * Show the form for editing tphe specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $method = 'Method => elearningEthnicTestController =>edit';
            $id = $this->decryptData($id);
            $row = DB::table('elearning_ethnictest')
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
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //

        try {
            $method = 'Method => elearningEthnicTestController => update';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'user_category' => $inputArray['user_category'],
                'ethnictest_name' => $inputArray['ethnictest_name'],
                'quiz_id' => $inputArray['quiz_id'],
                'pass_percentage' => $inputArray['pass_percentage'],
                'eid' => $inputArray['eid'],
            ];

            $update_id = DB::table('elearning_ethnictest')
                ->where('id', $input['eid'])
                ->update([
                    'user_category' => $input['user_category'],
                    'ethnictest_name' => $input['ethnictest_name'],
                    'quiz_id' => $input['quiz_id'],
                    'pass_percentage' => $input['pass_percentage'],
                    'active_flag' => '0',
                    'updated_by' => auth()->user()->id,
                    'updated_at' => NOW()

                ]);
            $this->notifications_insert(null, auth()->user()->id, "Ethic Test Updated Successfully", "/ethictest");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_ethnictest', $update_id, 'Update', 'Update Ethic Test', auth()->user()->id, NOW(), $role_name_fetch);

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
            $method = 'Method => elearningEthnicTestController =>fetch';
            $userID = auth()->user()->id;
            // $rows = DB::select("SELECT role_id from uam_roles  where user_id=$userID");
            // $role_id=$rows[0]->role_id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
            ];
            $id = $input['id'];
            $rows = DB::select("SELECT *  from elearning_ethnictest  where id = $id ");
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */




    public function delete(Request $request)
    {
        try {
            $method = 'Method => elearningEthnicTestController => update';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
            ];

            $update_id =  DB::table('elearning_ethnictest')
                ->where('id', $input['id'])
                ->update([

                    'active_flag' => '1',


                ]);

            $this->notifications_insert(null, auth()->user()->id, "Ethic Test Deleted Successfully", "/ethictest");

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_ethnictest', $update_id, 'Delete', 'Delete Ethic Test', auth()->user()->id, NOW(), $role_name_fetch);

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
        $method = 'Method => elearningEthnicTestController => list';
        try {
            $userID = auth()->user()->id;

            $rows = DB::select("SELECT role_id from uam_user_roles  where user_id=$userID");
            $role_id = $rows[0]->role_id;
            $rows = DB::select("SELECT * FROM elearning_ethnictest WHERE user_category= $role_id and active_flag=0 ");

            if ($rows == []) {
                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.success');
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 0;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                return $sendServiceResponse;
            }

            $rows = DB::select("SELECT * FROM elearning_userethnic WHERE user_id=$userID");

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
            $this->WriteFileLog($exceptionResponse);
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
            $method = 'Method => elearningEthnicTestController =>quiz';
            $userID = auth()->user()->id;

            $rows = DB::select("SELECT role_id from uam_user_roles  where user_id=$userID");

            $role_id = $rows[0]->role_id;
            if ($role_id == 35) {
                $role_id = 34;
            }

            $maxId = DB::select("SELECT id from elearning_ethnictest where user_category =$role_id and active_flag=0 order by id desc limit 0,1");
            $max = $maxId[0]->id;
            $availableQuizzes = DB::select("SELECT id from elearning_ethnictest where user_category =$role_id and active_flag=0");
            $availableQuizIds = [];
            foreach ($availableQuizzes as $availableQuiz) {
                array_splice($availableQuizIds, 1, 0, $availableQuiz->id);
            }
            do {
                $randomNumber = rand(1, $max);
            } while (!(in_array($randomNumber, $availableQuizIds)));
            $random_quizid = DB::select("Select quiz_id from elearning_ethnictest where id=$randomNumber");
            $random_quizid = $random_quizid[0]->quiz_id;
            $randomQuiz = DB::select("Select * from elearning_practice_quiz where quiz_id= $random_quizid");
            // $randomQuiz = DB::select("Select * from elearning_ethnictest inner join elearning_practice_quiz on elearning_practice_quiz.quiz_id = elearning_ethnictest.quiz_id  where elearning_ethnictest.quiz_id=$randomNumber");

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
            // dd($questionDetails);
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
            $method = 'Method => elearningEthnicTestController => quizstore';
            $user_id = auth()->user()->id;
            $inputArray = $this->decryptData($request->requestData);
            $maxId = DB::select("select quiz_id from elearning_ethnictest order by quiz_id desc limit 0,1");
            $max = $maxId[0]->quiz_id;
            $availableQuizzes = DB::select("select quiz_id from elearning_ethnictest where active_flag=0");
            $availableQuizIds = [];
            foreach ($availableQuizzes as $availableQuiz) {
                array_splice($availableQuizIds, 1, 0, $availableQuiz->quiz_id);
            }
            do {
                $randomNumber = rand(1, $max);
            } while (!(in_array($randomNumber, $availableQuizIds)));
            $randomQuiz = DB::select("select * from elearning_ethnictest inner join elearning_practice_quiz on elearning_practice_quiz.quiz_id = elearning_ethnictest.quiz_id  where elearning_ethnictest.quiz_id=$randomNumber");
            $quizId = $randomQuiz[0]->quiz_id;
            $pass_percentage =  $randomQuiz[0]->pass_percentage;


            $attempt = DB::select("SELECT count('id') as count from elearning_userethnic where user_id=$user_id");

            $previousattemptcount = $attempt[0]->count;
            $attemptcount = $previousattemptcount + 1;
            $totalpoints = DB::select("SELECT points from elearning_practice_quiz where quiz_id=$quizId");
            $totalpoints = $totalpoints[0]->points;
            $calc = ($pass_percentage / 100) * intval($totalpoints);

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


            $update_id = DB::transaction(function () use ($input) {
                $settings_id = DB::table('elearning_userethnic')
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
            });

            $this->notifications_insert(null, auth()->user()->id, "Thanks for Attending the Ethics Test" . "Score:" . $input['score'], "/ethic/quiz/list");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_userethnic', $update_id, 'Attending the Ethics Test', 'Thanks for Attending the Ethics Test', auth()->user()->id, NOW(), $role_name_fetch);

            $email = $this->getusermail($user_id);
            $name = $this->getusername($user_id);
            $base_url = config('setting.base_url');

            $data = array(
                'name' => $name,
                'email' => $email,
                'score' => $input['score'],
                'base_url' => $base_url
            );

            Mail::to($data['email'])->send(new ethictestmail($data));


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
    public function class_quiz(Request $request)
    {

        $method = 'Method => elearningEthnicTestController =>class_quiz';
        try {

            $userID = auth()->user()->id;
            $inputArray = $this->decryptData($request->requestData);

            $input = [
                'course_id' => $inputArray['course_id'],
                'class_id' => $inputArray['class_id'],

            ];
            $class_id = $input['class_id'];
            $course_id = $input['course_id'];
            $random_quizid = DB::select("Select quiz_id from elearning_classes where class_id=$class_id");
            $random_quizid = $random_quizid[0]->quiz_id;
            $randomQuiz = DB::select("Select * from elearning_practice_quiz where quiz_id= $random_quizid");
            // $randomQuiz = DB::select("Select * from elearning_ethnictest inner join elearning_practice_quiz on elearning_practice_quiz.quiz_id = elearning_ethnictest.quiz_id  where elearning_ethnictest.quiz_id=$randomNumber");

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
            $qIds = $randomQuiz[0]->quiz_questions;
            $response = [
                'quizId' => $quizId,
                'quizName' => $quizName,
                'questionDetails' => $questionDetails,
                'qIds' => $qIds,
                'course_id' => $course_id,
                'class_id' => $class_id,

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
    public function quiz_store(Request $request)
    {

        try {
            $method = 'Method => elearningEthnicTestController => quiz_store';
            $user_id = auth()->user()->id;
            $inputArray = $this->decryptData($request->requestData);
            $inputArray = $this->decryptData($request->requestData);

            $input = [
                'course_id' => $inputArray['course_id'],
                'class_id' => $inputArray['class_id'],

            ];
            $class_id = $input['class_id'];
            $course_id = $input['course_id'];
            $randomQuiz = DB::select("select * from elearning_classes inner join elearning_practice_quiz on elearning_practice_quiz.quiz_id = elearning_classes.quiz_id  where elearning_classes.class_id=$class_id");

            $quizId = $randomQuiz[0]->quiz_id;


            $attempt = DB::select("SELECT count('id') as count from elearning_coursequiz where user_id=$user_id and course_id= $course_id and class_id= $class_id");

            $previousattemptcount = $attempt[0]->count;
            $attemptcount = $previousattemptcount + 1;
            $totalpoints = DB::select("SELECT points from elearning_practice_quiz where quiz_id=$quizId");
            $totalpoints = $totalpoints[0]->points;
            $calc = (35 / 100) * intval($totalpoints);
            if ($inputArray['score'] >= $calc) {
                $result = "PASS";
                DB::table('user_class_relation')
                    ->where('course_id', $input['course_id'])
                    ->where('class_id', $input['class_id'])
                    ->where('user_id', $user_id)

                    ->update([
                        'quiz_status' => 1,

                    ]);

                $total_classes = DB::select("SELECT COUNT(*) as total_classes FROM user_class_relation where course_id=$course_id and user_id=$user_id");
                $totalClasses = (int) $total_classes[0]->total_classes;
                $total_classes_completed = DB::select("SELECT COUNT(*) AS total_classes
            FROM user_class_relation AS cr
            INNER JOIN elearning_classes AS c ON c.class_id = cr.class_id
            WHERE cr.status = 2
              AND cr.course_id = $course_id
              AND cr.user_id = $user_id
              AND (CASE WHEN c.class_quiz = 'yes' THEN cr.quiz_status = 1 ELSE 1 END)");
                $totalClassesCount = (int) $total_classes_completed[0]->total_classes;
                if ($total_classes_completed != []) {
                    $progressPercentage = ($totalClassesCount / $totalClasses) * 100;
                    //dd($progressPercentage);
                    $progress = round($progressPercentage);
                    if ($progress == 100) {

                        $progress = $progress - 20;
                    }
                    DB::table('user_course_relation')
                        ->where('course_id',  $course_id)
                        ->where('user_id',  $user_id)
                        ->update([
                            'course_progress' => $progress,
                        ]);
                }
                $is_completed = Db::select("SELECT * from user_class_relation where status=1 and status=0");
                if ($is_completed == []) {
                    DB::table('user_class_relation')
                        ->where('course_id',  $course_id)
                        ->where('class_id',  $class_id)
                        ->where('user_id',  $user_id)
                        ->update([
                            'status' => 2,
                        ]);

                    $is_pending = DB::select("SELECT cr.* from user_class_relation as cr where cr.course_id=$course_id and cr.status=1 and cr.user_id=$user_id");
                    if ($is_pending == []) {
                        DB::statement("UPDATE user_class_relation SET status = 1 WHERE user_id = $user_id AND status NOT IN (2) AND course_id =$course_id ORDER BY id ASC LIMIT 1");
                    }
                }
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
                'class_id' => $class_id,
                'course_id' => $course_id

            ];



            $update_id = DB::transaction(function () use ($input) {
                $settings_id = DB::table('elearning_coursequiz')
                    ->insertGetId([
                        'quiz_id' => $input['quiz_id'],
                        'attempt' => $input['attempt'],
                        'score' => $input['score'],
                        'pass_mark' => $input['pass_mark'],
                        'total_scores' => $input['total_scores'],
                        'result' => $input['result'],
                        'class_id' => $input['class_id'],
                        'course_id' => $input['course_id'],
                        'user_id' => auth()->user()->id,
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
            });


            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_coursequiz', $update_id, 'Attending the Course Quiz', 'Thanks for Attending the Course Quiz', auth()->user()->id, NOW(), $role_name_fetch);

            //  $this->notifications_insert(null, auth()->user()->id, "Thanks for Attending the Quiz" . "Score:" . $input['score'], "/ethic/quiz/list");

            // $email = $this->getusermail($user_id);
            // $name = $this->getusername($user_id);
            // $base_url = config('setting.base_url');

            // $data = array(
            //     'name' => $name,
            //     'email' => $email,
            //     'score' => $input['score'],
            //     'base_url' => $base_url
            // );

            //Mail::to($data['email'])->send(new ethictestmail($data));


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
    public function generatePDF(Request $request)
    {
        $method = 'Method => elearningEthnicTestController => generatePDF';
        try {
            $user_id = auth()->user()->id;

            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'date' => $inputArray['date'],
                'course_name' => $inputArray['course_name'],
                'name' => $inputArray['name'],
                'attach' => $inputArray['attach'],

            ];

            $course_name = $input['course_name'];
            $email = $this->getusermail($user_id);
            $name = $this->getusername($user_id);
            $base_url = config('setting.base_url');

            $data = array(
                'name' => $name,
                'course_name' => $course_name,
                'email' => $email,
                'base_url' => $base_url,
                'attach' => $input['attach']
            );
            $this->notifications_insert(null, auth()->user()->id, "Thankyou for completing the course-$course_name and certificate has sent to your mail", "/ethictest");

            // Mail::to($data['email'])->send(new coursecertificate($data));


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
    public function course_exam(Request $request)
    {

        $method = 'Method => elearningEthnicTestController =>course_exam';
        try {

            $userID = auth()->user()->id;
            $inputArray = $this->decryptData($request->requestData);

            $input = [
                'course_id' => $inputArray['course_id'],
                'class_id' => $inputArray['class_id'],

            ];
            $class_id = $input['class_id'];
            $course_id = $input['course_id'];
            $random_quizid = DB::select("SELECT c.exam_id,c.*,e.exam_name,e.quiz_id from elearning_courses as c inner join elearning_exam  as e on c.exam_id=e.id where course_id=$course_id");
            $random_quizid = $random_quizid[0]->quiz_id;
$this->WriteFileLog($random_quizid);
            $randomQuiz = DB::select("Select * from elearning_practice_quiz where quiz_id= $random_quizid");
            // $randomQuiz = DB::select("Select * from elearning_ethnictest inner join elearning_practice_quiz on elearning_practice_quiz.quiz_id = elearning_ethnictest.quiz_id  where elearning_ethnictest.quiz_id=$randomNumber");

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
            $qIds = $randomQuiz[0]->quiz_questions;
            $response = [
                'quizId' => $quizId,
                'quizName' => $quizName,
                'questionDetails' => $questionDetails,
                'qIds' => $qIds,
                'course_id' => $course_id,
                'class_id' => $class_id,

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
    public function exam_store(Request $request)
    {

        try {
            $method = 'Method => elearningEthnicTestController => exam_store';
            $user_id = auth()->user()->id;
            //$inputArray = $this->decryptData($request->requestData);
            $inputArray = $this->decryptData($request->requestData);
            $this->WriteFileLog($inputArray, "inputArray");

            $input = [
                'course_id' => $inputArray['course_id'],
                'class_id' => $inputArray['class_id'],

            ];
            $class_id = $input['class_id'];
            $course_id = $input['course_id'];
            $randomQuiz =  DB::select("select c.*,e.* from elearning_courses  as c inner join elearning_exam as e on e.id= c.exam_id  where c.course_id=$course_id and drop_course=0");

            $quizId = $randomQuiz[0]->quiz_id;
            $examId = $randomQuiz[0]->exam_id;


            // $attempt = DB::select("SELECT count('id') as count from elearning_coursequiz where user_id=$user_id and course_id= $course_id and class_id= $class_id");

            // $previousattemptcount = $attempt[0]->count;
            // $attemptcount = $previousattemptcount + 1;
            $totalpoints = DB::select("SELECT points from elearning_practice_quiz where quiz_id=$quizId");
            $totalpoints = $totalpoints[0]->points;
            $test_percentage = ($inputArray['score'] / $totalpoints) * 100;


            // $calc = (35 / 100) * intval($totalpoints);
            $this->WriteFileLog($totalpoints);
            $this->WriteFileLog($inputArray['score']);
            $this->WriteFileLog('wsdfe');
            // $this->WriteFileLog($calc);
            //dd($calc);
            // $passmark=20;
            $course_exam_percentage = DB::select("SELECT c.pass_percentage from elearning_courses as c where c.exam_id=$examId and c.course_id=$course_id");

            if ($test_percentage >= $course_exam_percentage[0]->pass_percentage) {
                $result = "PASS";
            } else {
                $result = "FAIL";
            }
            $this->WriteFileLog($result);
            $input = [
                'quiz_id' => $quizId,
                'score' => $inputArray['score'],
                'total_scores' => $inputArray['total_scores'],
                'result' =>  $result,
                'class_id' => $class_id,
                'course_id' => $course_id,
                'exam_id' => $examId

            ];


            $this->WriteFileLog($input);

            DB::transaction(function () use ($input) {
                $settings_id = DB::table('elearning_courseexam')
                    ->insertGetId([
                        'quiz_id' => $input['quiz_id'],
                        'exam_id' => $input['exam_id'],
                        'score' => $input['score'],

                        'total_scores' => $input['total_scores'],
                        'result' => $input['result'],
                        'class_id' => $input['class_id'],
                        'course_id' => $input['course_id'],
                        'user_id' => auth()->user()->id,
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
            });

            $course_certification = DB::select("SELECT c.*,uc.* from elearning_courses as c inner join user_course_relation as uc on c.course_id=uc.course_id where c.course_id=$course_id  and uc.user_id=$user_id");
            // pass
            $add_examprogress = $course_certification[0]->course_progress;
            $this->WriteFileLog($course_certification);

            $email = $this->getusermail($user_id);
            $name = $this->getusername($user_id);
            $base_url = config('setting.base_url');

            $data = array(
                'name' => $name,
                'email' => $email,
                'score' => $input['score'],
                'base_url' => $base_url
            );

            if ($result == "PASS") {
                if ($course_certification[0]->course_certificate == 1) {
                    // update progress to 100

                    $this->WriteFileLog($course_id);
                    $this->WriteFileLog($user_id);

                    //    
                    DB::table('user_course_relation')
                        ->where('course_id',  $course_id)
                        ->where('user_id',  $user_id)
                        ->update([
                            'get_certified' =>0,
                            'status' => 2,
                            'course_progress' => $add_examprogress + 20,
                            'exam_status' => 2,
                            'course_status' => 'Completed',
                        ]);
                } else {
                    // update progress to 100


                    // course Relation 2
                    DB::table('user_course_relation')
                        ->where('course_id',  $course_id)
                        ->where('user_id',  $user_id)
                        ->update([
                            'status' => 2,
                            'exam_status' => 2,
                            'course_status' => 'Completed',
                            'get_certified' => 0,
                        ]);
                }
                Mail::to($data['email'])->send(new exammail($data));
            } else {
                DB::table('user_course_relation')
                    ->where('course_id',  $course_id)
                    ->where('user_id',  $user_id)
                    ->update([
                        'status' => 2,
                        'exam_status' => 2,
                        'course_status' => 'Completed',
                        'get_certified' => 3,
                    ]);
                Mail::to($data['email'])->send(new exammail2($data));
            }

            $response = [
                'result' => $result,


            ];

            $this->notifications_insert(null, auth()->user()->id, "Thanks for Attending the Exam" . "Score:" . $input['score'], "/elearningCourse/class/eyJpdiI6IkppVU1SRlkzQmJ3eUlNOFFGYnM1bHc9PSIsInZhbHVlIjoiL2Y5cEFZVGxJSnNrR2d5aDJkdDRkUT09IiwibWFjIjoiNGI1NGIxYWQxMTlmNzYxY2NjMGRjNzdkMjkzMmUzZjdlMjk1ZjcyNzgwYmVkNmM3YjExYzI1OWY2ZmNjMGViNiIsInRhZyI6IiJ9");

            $email = $this->getusermail($user_id);
            $name = $this->getusername($user_id);
            $base_url = config('setting.base_url');

            $data = array(
                'name' => $name,
                'email' => $email,
                'score' => $input['score'],
                'base_url' => $base_url
            );




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
    public function cpt_index(Request $request)
    {
        try {
            $method = 'Method => elearningEthnicTestController => cpt_index';
            $user_id = auth()->user()->id;
            $rows['total_cptpoints'] = DB::select("SELECT u.total_cptpoints from users  AS u where active_flag=0 and u.id= $user_id");



            $rows['quiz_list'] = DB::select("SELECT uc.*,c.course_name from user_cpt_points as uc inner join elearning_courses as c on c.course_id=uc.course_id where c.drop_course=0 and uc.status=0 and uc.user_id=$user_id");

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
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
    public function cpt_mail(Request $request)
    {
        $method = 'Method => elearningEthnicTestController => cpt_mail';
        try {
            $user_id = auth()->user()->id;

            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'course_id' => $inputArray['course_id'],
            ];
            $course_id = $input['course_id'];
            $user_cpt = DB::select("SELECT uc.*,c.* from user_cpt_points as uc inner join elearning_courses as c on uc.course_id=c.course_id where uc.status=0 and uc.course_id=$course_id and uc.user_id=$user_id");
            $users = DB::select("SELECT * from users where active_flag=0 and id=$user_id");
            $course_name = $user_cpt[0]->course_name;
            $cpt_points = $user_cpt[0]->cpt_points;

            $total_cptpoints = $users[0]->total_cptpoints;
            $email = $this->getusermail($user_id);
            $name = $this->getusername($user_id);
            $base_url = config('setting.base_url');

            $data = array(
                'name' => $name,
                'course_name' => $course_name,
                'total_cptpoints' => $total_cptpoints,
                'cpt_points' => $cpt_points,
                'email' => $email,
                'base_url' => $base_url
            );


            Mail::to($data['email'])->send(new cptmail($data));


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

    public function ratings_store(Request $request)
    {
        try {
            $method = 'Method => elearningEthnicTestController => ratings_store';
            $user_id = auth()->user()->id;

            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'course_id' => $inputArray['course_id'],
                'review' => $inputArray['review'],
                'rating_point' => $inputArray['rating_point'],
                'user_id' => $inputArray['user_id'],

            ];
            $update_id = DB::transaction(function () use ($input) {
                $settings_id = DB::table('elearning_ratings')
                    ->insertGetId([
                        'course_id' => $input['course_id'],
                        'review' => $input['review'],
                        'rating_point' => $input['rating_point'],
                        'user_id' => $input['user_id'],

                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
            });

            // $this->notifications_insert(null, auth()->user()->id, "Ethic Test Created Successfully", "/ethictest");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_ratings', $update_id, 'Create', 'Ratings Added', auth()->user()->id, NOW(), $role_name_fetch);


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
    public function rating_index(Request $request)
    {
        try {
            $method = 'Method => elearningEthnicTestController => rating_index';
            $unique_rows = [];
            $rows['rating_list'] = DB::select('SELECT r.created_at,r.course_id, AVG(r.rating_point) as average_rating, c.course_name
            FROM elearning_ratings as r
            INNER JOIN elearning_courses as c ON c.course_id = r.course_id
            WHERE c.drop_course = 0
            GROUP BY r.created_at,r.course_id,c.course_name;');
            $pre_course_id = 0;
            foreach ($rows['rating_list'] as $key => $row) {
                if ($row->course_id != $pre_course_id) {
                    $unique_rows[$key] = $row;
                }
                $pre_course_id = $row->course_id;
            }
            $response = [
                'rows' => $unique_rows
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
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
    public function cart_index(Request $request)
    {
        try {
            $method = 'Method => elearningEthnicTestController => rating_index';
            $userID = auth()->user()->id;
            $this->WriteFileLog($userID);
            $cartCourseIds=[];
            $wishListCourseIds=[];
            $rows['cart_list'] = DB::select("SELECT r.*,c.course_name,c.course_instructor,c.course_price,c.course_banner,Null as average_rating from elearning_cart as r inner join elearning_courses as c on c.course_id=r.course_id where c.drop_course=0 and r.user_id= $userID and r.active_flag=0");
            //$rows['ratings'] = DB::select("SELECT r.* from elearning_ratings where r.user_id= $userID");
            $rows['wish_list'] = DB::select("SELECT r.*,c.course_name,c.course_instructor,c.course_price,c.course_banner,Null as average_rating from elearning_wishlist as r inner join elearning_courses as c on c.course_id=r.course_id where c.drop_course=0 and r.user_id= $userID and r.active_flag=0");
            $this->WriteFileLog($rows['cart_list']);
            $this->WriteFileLog($rows['wish_list']);
            foreach ($rows['cart_list'] as $key => $value) {
                # code...
                $courseId = $value->course_id;
                $rows['ratings'] = DB::select("Select * from elearning_ratings where course_id= $courseId");
                $this->WriteFileLog($rows['ratings']);
                $total_starcount = DB::Select("SELECT COUNT(*) as star_count FROM elearning_ratings where course_id=$courseId");
                if ($total_starcount[0]->star_count > 0) {
                    $total_star = DB::select("SELECT SUM(rating_point) AS sum_rating FROM elearning_ratings WHERE course_id = $courseId");
                    $rows['cart_list'][$key]->average_rating = number_format(floatval($total_star[0]->sum_rating / $total_starcount[0]->star_count), 1);
                } else {
                    $rows['cart_list'][$key]->average_rating = 0;
                }
                $cartCourseIds[] = $courseId;
            }

            foreach ($rows['wish_list'] as $key1 => $value1) {
                # code...
                $courseId = $value1->course_id;
                $rows['ratings'] = DB::select("Select * from elearning_ratings where course_id= $courseId");
                $total_starcount = DB::Select("SELECT COUNT(*) as star_count FROM elearning_ratings where course_id=$courseId");
                if ($total_starcount[0]->star_count > 0) {
                    $total_star = DB::select("SELECT SUM(rating_point) AS sum_rating FROM elearning_ratings WHERE course_id = $courseId");
                    $rows['wish_list'][$key1]->average_rating = number_format(floatval($total_star[0]->sum_rating / $total_starcount[0]->star_count), 1);
                } else {
                    $rows['wish_list'][$key1]->average_rating = 0;
                }
                $wishListCourseIds[] = $courseId;
            }


            $rows['cart_count'] = DB::select("SELECT count(*) as total_count from elearning_cart  where active_flag=0 and user_id=$userID");
            $rows['wish_count'] = DB::select("SELECT count(*) as total_count from elearning_wishlist as r inner join elearning_courses as c on c.course_id=r.course_id where c.drop_course=0 and r.user_id= $userID and r.active_flag=0");

            $response = [
                'rows' => $rows,
                'cartCourseIds' => $cartCourseIds,
                'wishListCourseIds' => $wishListCourseIds,

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
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
    public function cart_store(Request $request)
    {
        try {
            $method = 'Method => elearningEthnicTestController => cart_store';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'course_id' => $inputArray['course_id'],
                'user_id' => $inputArray['user_id'],


            ];
            $update_id = DB::transaction(function () use ($input) {
                $settings_id = DB::table('elearning_cart')
                    ->insertGetId([
                        'course_id' => $input['course_id'],
                        'user_id' => $input['user_id'],
                        'cart_added' => '1',
                        'active_flag' => '0',
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
            });

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_cart', $update_id, 'Create', 'Cart Added', auth()->user()->id, NOW(), $role_name_fetch);


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
    public function cart_delete(Request $request)
    {
        try {
            $method = 'Method => elearningEthnicTestController => cart_delete';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
            ];

            $rows = DB::table('elearning_cart')
                ->where('id', $input['id'])
                ->update([

                    'active_flag' => '1',


                ]);

            //$this->notifications_insert(null, auth()->user()->id, "Ethic Test Deleted Successfully", "/ethictest");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_cart', $rows, 'Delete', 'Cart Deletion', auth()->user()->id, NOW(), $role_name_fetch);

            $response = [
                'rows' => $rows
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
    public function move_cart(Request $request)
    {
        try {
            $method = 'Method => elearningEthnicTestController => move_cart';
            $user_id = auth()->user()->id;

            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'course_id' => $inputArray['course_id'],
                'user_id' => $inputArray['user_id'],

            ];
            $rows = DB::transaction(function () use ($input) {
                $settings_id = DB::table('elearning_cart')
                    ->insertGetId([
                        'course_id' => $input['course_id'],
                        'user_id' => $input['user_id'],
                        'active_flag' => 0,
                        'cart_added' => 1,
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
            });

            $rows = DB::table('elearning_wishlist')
                ->where('course_id', $input['course_id'])
                ->where('user_id', $input['user_id'])
                ->update([

                    'active_flag' => '1',


                ]);
            // $this->notifications_insert(null, auth()->user()->id, "Ethic Test Created Successfully", "/ethictest");
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
