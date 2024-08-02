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
use App\Mail\exammail;


class elearningExamController extends BaseController
{
    public function index(Request $request)
    {
        try {
            //$this->WriteFileLog("API HITTED");
            $method = 'Method =>  elearningExamController => index';
            $rows['quiz_dropdown'] = DB::select('SELECT e.* from elearning_practice_quiz  AS e left join elearning_localadaptation AS l ON e.quiz_id=l.quiz_id left join elearning_ethnictest AS et ON e.quiz_id=et.quiz_id left join elearning_classes AS ec ON e.quiz_id=ec.quiz_id WHERE l.quiz_id IS NULL AND et.quiz_id IS NULL and ec.quiz_id IS NULL AND e.drop_quiz=0');
            $rows['user_category'] = array(
                'Graduate Trainee' => config('setting.roles.Graduate Trainee'),
                'Professional Member' => config('setting.roles.professional_member'),
            );
            $this->WriteFileLog($rows);


            $rows['quiz_list'] = DB::select('SELECT et.id,et.user_category,ur.role_name,et.exam_name,et.quiz_id,eq.quiz_name from elearning_exam as et inner join elearning_practice_quiz as eq  on eq.quiz_id = et.quiz_id INNER JOIN uam_roles AS ur ON ur.role_id = et.user_category where et.active_flag=0');


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
            $method = 'Method => elearningExamController => store';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'user_category' => $inputArray['user_category'],
                'exam_name' => $inputArray['exam_name'],
                'quiz_id' => $inputArray['quiz_id'],

            ];
            $rows=DB::transaction(function () use ($input) {
                $settings_id = DB::table('elearning_exam')
                    ->insertGetId([
                        'user_category' => $input['user_category'],
                        'exam_name' => $input['exam_name'],
                        'quiz_id' => $input['quiz_id'],
                        'active_flag' => '0',
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
            });

            $this->notifications_insert(null, auth()->user()->id, "Exam Created Successfully", "/examtest");

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_exam', $rows, 'Create', 'Exam Creation', auth()->user()->id, NOW(), $role_name_fetch);
           
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

        $method = 'Method => elearningExamController => show';
        try {

            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $id = $request->id;
            $this->WriteFileLog("fefeffe");
            $this->WriteFileLog($id);
            $row = DB::table('elearning_exam')
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
            $method = 'Method => elearningExamController =>edit';
            $id = $this->decryptData($id);
            $row = DB::table('elearning_exam')
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
            // $this->WriteFileLog($request);
            $method = 'Method => elearningExamController => update';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'user_category' => $inputArray['user_category'],
                'exam_name' => $inputArray['exam_name'],
                'quiz_id' => $inputArray['quiz_id'],
                'eid' => $inputArray['eid'],

            ];

            $rows= DB::table('elearning_exam')
                ->where('id', $input['eid'])
                ->update([
                    'user_category' => $input['user_category'],
                    'exam_name' => $input['exam_name'],
                    'quiz_id' => $input['quiz_id'],
                    'active_flag' => '0',
                    'updated_by' => auth()->user()->id,
                    'updated_at' => NOW()

                ]);

            $this->notifications_insert(null, auth()->user()->id, "Exam Updated Successfully", "/examtest");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_exam', $rows, 'Update', 'Exam Updation', auth()->user()->id, NOW(), $role_name_fetch);
           

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
        $this->WriteFileLog($request);

        try {
            $method = 'Method => elearningExamController =>fetch';
            $userID = auth()->user()->id;
            // $rows = DB::select("SELECT role_id from uam_roles  where user_id=$userID");
            // $role_id=$rows[0]->role_id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
            ];
            $id = $input['id'];
            $rows = DB::select("SELECT *  from elearning_exam  where id =  $id ");
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
            // $this->WriteFileLog($request);
            $method = 'Method => elearningExamController => update';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
            ];

            $rows=DB::table('elearning_exam')
                ->where('id', $input['id'])
                ->update([

                    'active_flag' => '1',


                ]);

            $this->notifications_insert(null, auth()->user()->id, "Exam Updated Successfully", "/examtest");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_exam', $rows, 'Delete', 'Exam Deletion', auth()->user()->id, NOW(), $role_name_fetch);
           

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
            $this->WriteFileLog("API HITTED");
            $userID = auth()->user()->id;
            $method = 'Method => elearningExamController => list';
            $rows = DB::select("SELECT role_id from uam_user_roles  where user_id=$userID");
            $role_id = $rows[0]->role_id;
            $rows = DB::select("SELECT * FROM elearning_exam WHERE user_category= $role_id and active_flag=0");
            if ($rows == []) {
                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.success');
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 0;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                return $sendServiceResponse;
            }

            $rows = DB::select("SELECT * FROM elearning_userexam WHERE user_id=$userID");


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

        $method = 'Method => elearningExamController =>quiz';
        try {

            $userID = auth()->user()->id;

            $rows = DB::select("SELECT role_id from uam_user_roles  where user_id=$userID");
            $this->WriteFileLog($rows);

            $role_id = $rows[0]->role_id;

            if ($role_id == 35) {
                $role_id = 34;
            }

            $maxId = DB::select("SELECT id from elearning_exam where user_category =$role_id and active_flag=0 order by id desc limit 0,1");
            $max = $maxId[0]->id;
            $this->WriteFileLog($max);
            $availableQuizzes = DB::select("SELECT id from elearning_exam where user_category =$role_id and active_flag=0");
            $this->WriteFileLog($availableQuizzes);
            $availableQuizIds = [];
            foreach ($availableQuizzes as $availableQuiz) {
                array_splice($availableQuizIds, 1, 0, $availableQuiz->id);
            }
            $this->WriteFileLog($availableQuizIds);
            do {
                $randomNumber = rand(1, $max);
            } while (!(in_array($randomNumber, $availableQuizIds)));
            $random_quizid = DB::select("Select quiz_id from elearning_exam where id=$randomNumber");
            $random_quizid = $random_quizid[0]->quiz_id;
            //$this->WriteFileLog($random_quizid);
            $randomQuiz = DB::select("Select * from elearning_practice_quiz where quiz_id= $random_quizid");
            //$this->WriteFileLog($randomQuiz);
            // $randomQuiz = DB::select("Select * from elearning_ethnictest inner join elearning_practice_quiz on elearning_practice_quiz.quiz_id = elearning_ethnictest.quiz_id  where elearning_ethnictest.quiz_id=$randomNumber");

            $quizName = $randomQuiz[0]->quiz_name;
            $quizId = $randomQuiz[0]->quiz_id;
            //$this->WriteFileLog($quizId);
            $questions = explode(",", $randomQuiz[0]->quiz_questions);
            $questionDetails = [];
            $index = 0;
            $this->WriteFileLog($randomQuiz);
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
            $this->WriteFileLog($questionDetails);
            // for result valuation
            $qIds = $randomQuiz[0]->quiz_questions;
            $response = [
                'quizId' => $quizId,
                'quizName' => $quizName,
                'questionDetails' => $questionDetails,
                'qIds' => $qIds,

            ];
            $this->WriteFileLog($response);

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
            $method = 'Method => elearningExamController => quizstore';
            $user_id = auth()->user()->id;
            $inputArray = $this->decryptData($request->requestData);
            $maxId = DB::select("select quiz_id from elearning_exam order by quiz_id desc limit 0,1");
            $max = $maxId[0]->quiz_id;
            $availableQuizzes = DB::select("select quiz_id from elearning_exam where active_flag=0");
            $availableQuizIds = [];
            foreach ($availableQuizzes as $availableQuiz) {
                array_splice($availableQuizIds, 1, 0, $availableQuiz->quiz_id);
            }
            do {
                $randomNumber = rand(1, $max);
            } while (!(in_array($randomNumber, $availableQuizIds)));
            $randomQuiz = DB::select("select * from elearning_exam inner join elearning_practice_quiz on elearning_practice_quiz.quiz_id = elearning_exam.quiz_id  where elearning_exam.quiz_id=$randomNumber");

            $quizId = $randomQuiz[0]->quiz_id;


            $attempt = DB::select("SELECT count('id') as count from elearning_userexam where user_id=$user_id");

            $previousattemptcount = $attempt[0]->count;
            $attemptcount = $previousattemptcount + 1;
            $totalpoints = DB::select("SELECT points from elearning_practice_quiz where quiz_id=$quizId");
            $totalpoints = $totalpoints[0]->points;
            $calc = (35 / 100) * intval($totalpoints);
            $this->WriteFileLog($totalpoints);
            $this->WriteFileLog($inputArray['score']);
            $this->WriteFileLog('wsdfe');
            $this->WriteFileLog($calc);
            //dd($calc);
            // $passmark=20;

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


            $this->WriteFileLog($input);

            $rows= DB::transaction(function () use ($input) {
                $settings_id = DB::table('elearning_userexam')
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

            $this->notifications_insert(null, auth()->user()->id, "Thanks for Attending the Exam" . "Score:" . $input['score'], "/exam/quiz/list");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_exam', $rows, 'Store', 'Exam Quiz Store', auth()->user()->id, NOW(), $role_name_fetch);
           
            $email = $this->getusermail($user_id);
            $name = $this->getusername($user_id);
            $base_url = config('setting.base_url');

            $data = array(
                'name' => $name,
                'email' => $email,
                'score' => $input['score'],
                'base_url' => $base_url
            );

            Mail::to($data['email'])->send(new exammail($data));


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
