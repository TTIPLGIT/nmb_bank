<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\If_;

class ElearningQuestionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // Quiz Start

    public function index(Request $request)
    {
        try {
            $method = 'Method => ElearningQuestionController => index';



            $rows['long'] = DB::select('SELECT question_id as id ,question_name,question,points from elearning_questions_long_answer where drop_question=0 ORDER BY created_at DESC ');
            $rows['short'] = DB::select('SELECT question_id as id ,question_name,question,points from elearning_questions_short_answer where drop_question=0 ORDER BY created_at DESC');
            $rows['mcq'] = DB::select('SELECT question_id as id ,question_name,question,points from elearning_questions_mcq where drop_question=0 ORDER BY created_at DESC');
            $rows['true'] = DB::select('SELECT question_id as id ,question_name,question,points from elearning_questions_true_false where drop_question=0 ORDER BY created_at DESC');
            $rows['quiz_question'] = DB::select('SELECT concat(lng.question_id,"-",lng.question_type) as question_id,concat(lng.question_name,"    ","[",lng.question_type,"]") as name from elearning_questions_long_answer AS lng WHERE drop_question=0 UNION ALL  SELECT  concat(srt.question_id,"-",srt.question_type) as question_id, concat(srt.question_name,"    ","[",srt.question_type,"]") as name FROM elearning_questions_short_answer AS srt WHERE drop_question=0 UNION ALL  SELECT  concat(tru.question_id,"-",tru.question_type) as question_id,concat(tru.question_name,"  ","[","T/F","]")as name FROM elearning_questions_true_false AS tru WHERE drop_question=0 UNION ALL  SELECT  concat(mcq.question_id,"-",mcq.question_type) as question_id ,concat(mcq.question_name,"    ","[",mcq.question_type,"]") as name FROM elearning_questions_mcq AS mcq WHERE drop_question=0 ');
            $rows['quiz'] = DB::select('SELECT q.* from elearning_practice_quiz as q where q.drop_quiz=0 ORDER BY created_at DESC');

            foreach ($rows['quiz'] as $key => $row) {
                $new_value = explode(',', $row->quiz_questions);
                $rows['quiz'][$key]->quiz_questions = $new_value;
                # code...
            }
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
    public function long_store(Request $request)
    {
        try {
            $method = 'Method => ElearningQuestionController => long_store';
            $inputArray = $this->decryptData($request->requestData);


            $settings_id =  $inputArray['keywords'];
            $stringsettings_id_lower = implode(",", array_map('strtolower', $settings_id));
            $input = [
                'question_name' => $inputArray['question_name'],
                'question' => $inputArray['question'],
                'keywords' => $stringsettings_id_lower,
                'points' => $inputArray['points'],



            ];

            $update_id = DB::transaction(function () use ($input) {
                $settings_id = DB::table('elearning_questions_long_answer')
                    ->insertGetId([
                        'question_name' => $input['question_name'],
                        'question' => $input['question'],
                        'keywords' => $input['keywords'],
                        'points' => $input['points'],
                        'question_type' => "long",
                        'drop_question' => '0',
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
            });


            $this->notifications_insert(null, auth()->user()->id, "Long Questions Created Successfully", "/elearningquestion");

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_questions_long_answer', $update_id, 'Create', 'Long Question Creation', auth()->user()->id, NOW(), $role_name_fetch);



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
    public function long_show(Request $request)
    {

        $method = 'Method => ElearningQuestionController => long_show';
        try {

            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $id = $request->id;
            $row = DB::table('elearning_questions_long_answer')
                ->select('*')
                ->where('question_id', $id)
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
    public function long_edit($id)
    {
        try {
            $method = 'Method => ElearningQuestionController =>long_edit';
            $id = $this->decryptData($id);
            $row = DB::table('elearning_questions_long_answer')
                ->select('*')
                ->where('question_id', $id)
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
    public function long_update(Request $request)
    {
        //

        try {
            $method = 'Method => ElearningQuestionController => long_update';
            $inputArray = $this->decryptData($request->requestData);
            $settings_id =  $inputArray['keywords'];

            $stringsettings_id_lower = implode(",", array_map('strtolower', $settings_id));
            $input = [
                'question_name' => $inputArray['question_name'],
                'question' => $inputArray['question'],
                'keywords' =>  $stringsettings_id_lower,
                'points' => $inputArray['points'],
                'eid' => $inputArray['eid'],

            ];

            $update_id = DB::table('elearning_questions_long_answer')
                ->where('question_id', $input['eid'])
                ->update([
                    'question_name' => $input['question_name'],
                    'question' => $input['question'],
                    'keywords' => $input['keywords'],
                    'points' => $input['points'],
                    'question_type' => "long",
                    'drop_question' => '0',
                    'updated_by' => auth()->user()->id,
                    'updated_at' => NOW()

                ]);

            $this->notifications_insert(null, auth()->user()->id, "Long Questions Updated Successfully", "/elearningquestion");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_questions_long_answer', $update_id, 'Update', 'Long Question Updation', auth()->user()->id, NOW(), $role_name_fetch);


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
    public function long_fetch(Request $request)
    {

        try {
            $method = 'Method => ElearningQuestionController =>long_fetch';
            $userID = auth()->user()->id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
                'type' => $inputArray['type'],
            ];
            $id = $input['id'];
            if ($input['type'] == "longedit") {
                $rows = DB::select("SELECT *  from elearning_questions_long_answer  where question_id =  $id");
            } else if ($input['type'] == "longshow") {
                $rows = DB::select("SELECT *  from elearning_questions_long_answer  where question_id =  $id");
            } else if ($input['type'] == "shortedit") {
                $rows = DB::select("SELECT *  from elearning_questions_short_answer  where question_id =  $id");
            } else if ($input['type'] == "shortshow") {
                $rows = DB::select("SELECT *  from elearning_questions_short_answer  where question_id =  $id");
            } else if ($input['type'] == "trueedit") {
                $rows = DB::select("SELECT *  from elearning_questions_true_false  where question_id =  $id");
            } else if ($input['type'] == "trueshow") {
                $rows = DB::select("SELECT *  from elearning_questions_true_false  where question_id =  $id");
            } else if ($input['type'] == "mcqedit") {
                $rows = DB::select("SELECT *  from elearning_questions_mcq  where question_id =  $id");
            } else if ($input['type'] == "mcqshow") {
                $rows = DB::select("SELECT *  from elearning_questions_mcq  where question_id =  $id");
            } else if ($input['type'] == "quizedit") {
                $rows = DB::select("SELECT *  from elearning_practice_quiz  where quiz_id =  $id");
            } else if ($input['type'] == "quizshow") {
                $rows = DB::select("SELECT *  from elearning_practice_quiz  where quiz_id =  $id");
            }

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
    public function long_delete(Request $request)
    {
        try {
            $method = 'Method => LocalAdoptationTestController => update';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
                'tabletype' => $inputArray['tabletype'],
            ];
            $id = $input['id'];
            if ($input['tabletype'] == "1") {
                $update_id = DB::table('elearning_questions_long_answer')
                    ->where('question_id', $input['id'])
                    ->update([

                        'drop_question' => '1',

                    ]);
                $message = "Long Question Deleted Successfully";
                $this->notifications_insert(null, auth()->user()->id, "Long Question Deleted Successfully", "/elearningquestion");
                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                $role_name_fetch = $role_name[0]->role_name;
                $this->auditLog('elearning_questions_long_answer', $update_id, 'Deletion', 'Long Question Deletion', auth()->user()->id, NOW(), $role_name_fetch);
            } else if ($input['tabletype'] == "2") {

                $update_id =  DB::table('elearning_questions_short_answer')
                    ->where('question_id', $input['id'])
                    ->update([
                        'drop_question' => '1',
                    ]);
                $message = "Short Question Deleted Successfully";
                $this->notifications_insert(null, auth()->user()->id, "Short Question Deleted Successfully", "/elearningquestion");
                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                $role_name_fetch = $role_name[0]->role_name;
                $this->auditLog('elearning_questions_short_answer', $update_id, 'Deletion', 'Short Question Deletion', auth()->user()->id, NOW(), $role_name_fetch);
            } else if ($input['tabletype'] == "3") {

                $update_id = DB::table('elearning_questions_mcq')
                    ->where('question_id', $input['id'])
                    ->update([
                        'drop_question' => '1',
                    ]);
                $message = "MCQ Question Deleted Successfully";
                $this->notifications_insert(null, auth()->user()->id, "MCQ Question Deleted Successfully", "/elearningquestion");
                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                $role_name_fetch = $role_name[0]->role_name;
                $this->auditLog('elearning_questions_mcq', $update_id, 'Deletion', 'MCQ Question Deletion', auth()->user()->id, NOW(), $role_name_fetch);
            } else if ($input['tabletype'] == "4") {

                $update_id = DB::table('elearning_questions_true_false')
                    ->where('question_id', $input['id'])
                    ->update([
                        'drop_question' => '1',
                    ]);
                $message = "True/False Question Deleted Successfully";
                $this->notifications_insert(null, auth()->user()->id, "True/False Question Deleted Successfully", "/elearningquestion");
                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                $role_name_fetch = $role_name[0]->role_name;
                $this->auditLog('elearning_questions_true_false', $update_id, 'Deletion', 'True/False Question Deletion', auth()->user()->id, NOW(), $role_name_fetch);
            } else if ($input['tabletype'] == "5") {

                $ethicmapping = DB::select("SELECT *  from elearning_ethnictest  where quiz_id =$id  and active_flag=0");
                $localmapping = DB::select("SELECT *  from elearning_localadaptation  where quiz_id =$id and active_flag=0");
                $exammapping = DB::select("SELECT *  from elearning_exam  where quiz_id =$id  and active_flag=0");
                $classmapping = DB::select("SELECT *  from elearning_classes  where quiz_id =$id  and drop_class=0");


                if (!empty($ethicmapping) || !empty($localmapping) || !empty($exammapping) || !empty($classmapping)) {
                    $serviceResponse = array();
                    $serviceResponse['Code'] = config('setting.status_code.exception');
                    $serviceResponse['Message'] = "depend";
                    $quiz_type = (!empty($ethicmapping) ? "Ethic Test" : (!empty($localmapping) ? "Local Adaptation Test" : (!empty($exammapping) ? "Exam"  : (!empty($classmapping) ? "Class" : ""))));
                    $serviceResponse['response_message'] =  "This Quiz have Dependency on the " . $quiz_type;
                    $serviceResponse['Data'] = 0;
                    $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                    $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
                    return $sendServiceResponse;
                }
                $update_id = DB::table('elearning_practice_quiz')
                    ->where('quiz_id', $input['id'])
                    ->update([
                        'drop_quiz' => '1',
                    ]);
                $message = "Quiz Deleted Successfully";
                $this->notifications_insert(null, auth()->user()->id, "Quiz Deleted Successfully", "/elearningquestion");
                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                $role_name_fetch = $role_name[0]->role_name;
                $this->auditLog('elearning_practice_quiz', $update_id, 'Deletion', 'Quiz Deletion', auth()->user()->id, NOW(), $role_name_fetch);
            }
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
    public function short_store(Request $request)
    {
        try {
            $method = 'Method => ElearningQuestionController => short_store';
            $inputArray = $this->decryptData($request->requestData);


            $settings_id =  $inputArray['keywords'];
            $stringsettings_id_lower = implode(",", array_map('strtolower', $settings_id));

            // $stringsettings_id = implode(",", $settings_id);
            
            $input = [
                'question_name' => $inputArray['question_name'],
                'question' => $inputArray['question'],
                'keywords' => $stringsettings_id_lower,
                'points' => $inputArray['points'],



            ];

            $update_id = DB::transaction(function () use ($input) {
                $settings_id = DB::table('elearning_questions_short_answer')
                    ->insertGetId([
                        'question_name' => $input['question_name'],
                        'question' => $input['question'],
                        'keywords' => $input['keywords'],
                        'points' => $input['points'],
                        'question_type' => "short",
                        'drop_question' => '0',
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
            });
            $this->notifications_insert(null, auth()->user()->id, "Short Questions Created Successfully", "/elearningquestion");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_questions_short_answer', $update_id, 'Create', 'Short Question Creation', auth()->user()->id, NOW(), $role_name_fetch);



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
    public function short_show(Request $request)
    {

        $method = 'Method => ElearningQuestionController => short_show';
        try {

            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $id = $request->id;
            $row = DB::table('elearning_questions_short_answer')
                ->select('*')
                ->where('question_id', $id)
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
    public function short_edit($id)
    {
        try {
            $method = 'Method => ElearningQuestionController =>short_edit';
            $id = $this->decryptData($id);
            $row = DB::table('elearning_questions_short_answer')
                ->select('*')
                ->where('question_id', $id)
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
    public function short_update(Request $request)
    {
        //

        try {

            $method = 'Method => ElearningQuestionController => short_update';
            $inputArray = $this->decryptData($request->requestData);
            $settings_id =  $inputArray['keywords'];
            $stringsettings_id_lower = implode(",", array_map('strtolower', $settings_id));
            $input = [
                'question_name' => $inputArray['question_name'],
                'question' => $inputArray['question'],
                'keywords' =>  $stringsettings_id_lower,
                'points' => $inputArray['points'],
                'short_edit' => $inputArray['short_edit'],

            ];

            $update_id = DB::table('elearning_questions_short_answer')
                ->where('question_id', $input['short_edit'])
                ->update([
                    'question_name' => $input['question_name'],
                    'question' => $input['question'],
                    'keywords' => $input['keywords'],
                    'points' => $input['points'],
                    'question_type' => "short",
                    'drop_question' => '0',
                    'updated_by' => auth()->user()->id,
                    'updated_at' => NOW()

                ]);
            $this->notifications_insert(null, auth()->user()->id, "Short Question Updated Successfully", "/elearningquestion");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_questions_short_answer', $update_id, 'Update', 'Short Question Updation', auth()->user()->id, NOW(), $role_name_fetch);

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
    public function mcq_store(Request $request)
    {
        try {
            $method = 'Method => ElearningQuestionController => mcq_store';
            $inputArray = $this->decryptData($request->requestData);

            $settings_id =  $inputArray['keywords_choices'];
           // $stringsettings_id = implode(",", $settings_id);
           $stringsettings_id_lower = implode(",", array_map('strtolower', $settings_id));

            $choice =  $inputArray['correct_choices'];
            $choices_id = implode(",", array_map('strtolower', $choice));

            //$choices_id = implode(",", $choice);

            $input = [
                'question_name' => $inputArray['question_name'],
                'question' => $inputArray['question'],
                'keywords_choices' => $stringsettings_id_lower,
                'correct_choices' => $choices_id,
                'points' => $inputArray['points'],



            ];

            $update_id = DB::transaction(function () use ($input) {
                $settings_id = DB::table('elearning_questions_mcq')
                    ->insertGetId([
                        'question_name' => $input['question_name'],
                        'question' => $input['question'],
                        'choices' => $input['keywords_choices'],
                        'correct_choices' => $input['correct_choices'],
                        'points' => $input['points'],
                        'question_type' => "mcq",
                        'drop_question' => '0',
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
            });
            $this->notifications_insert(null, auth()->user()->id, "Mcq Question Created Successfully", "/elearningquestion");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_questions_mcq', $update_id, 'Create', 'MCQ Question Creation', auth()->user()->id, NOW(), $role_name_fetch);



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
    public function mcq_show(Request $request)
    {

        $method = 'Method => ElearningQuestionController => mcq_show';
        try {

            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $id = $request->id;
            $row = DB::table('elearning_questions_mcq')
                ->select('*')
                ->where('question_id', $id)
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
    public function mcq_edit($id)
    {
        try {
            $method = 'Method => ElearningQuestionController =>mcq_edit';
            $id = $this->decryptData($id);
            $row = DB::table('elearning_questions_mcq')
                ->select('*')
                ->where('question_id', $id)
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
    public function mcq_update(Request $request)
    {
        //

        try {
            $method = 'Method => ElearningQuestionController => mcq_update';
            $inputArray = $this->decryptData($request->requestData);
            $settings_id =  $inputArray['choices'];
            // $stringsettings_id = implode(",", $settings_id);
            $stringsettings_id_lower = implode(",", array_map('strtolower', $settings_id));

            $input = [
                'question_name' => $inputArray['question_name'],
                'question' => $inputArray['question'],
                'choices' =>  $stringsettings_id_lower,
                'correct_choices' => $inputArray['correct_choices'],
                'points' => $inputArray['points'],
                'mcq_edit' => $inputArray['mcq_edit'],

            ];

            $update_id = DB::table('elearning_questions_mcq')
                ->where('question_id', $input['mcq_edit'])
                ->update([
                    'question_name' => $input['question_name'],
                    'question' => $input['question'],
                    'choices' => $input['choices'],
                    'correct_choices' => $input['correct_choices'],
                    'points' => $input['points'],
                    'question_type' => "mcq",
                    'drop_question' => '0',
                    'updated_by' => auth()->user()->id,
                    'updated_at' => NOW()

                ]);
            $this->notifications_insert(null, auth()->user()->id, "Mcq Questions Updated Successfully", "/elearningquestion");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_questions_mcq', $update_id, 'Update', 'MCQ Question Updation', auth()->user()->id, NOW(), $role_name_fetch);

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
    public function true_store(Request $request)
    {
        try {
            $method = 'Method => ElearningQuestionController => true_store';
            $inputArray = $this->decryptData($request->requestData);

            $input = [
                'question_name' => $inputArray['question_name'],
                'question' => $inputArray['question'],
                'answer' => $inputArray['answer'],
                'points' => $inputArray['points']
            ];

            $update_id = DB::transaction(function () use ($input) {
                $settings_id = DB::table('elearning_questions_true_false')
                    ->insertGetId([
                        'question_name' => $input['question_name'],
                        'question' => $input['question'],
                        'answer' => $input['answer'],
                        'points' => $input['points'],
                        'question_type' => "boolean",
                        'drop_question' => '0',
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
            });
            $this->notifications_insert(null, auth()->user()->id, "T/F Question Created Successfully", "/elearningquestion");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_questions_true_false', $update_id, 'Create', 'T/F Question Creation', auth()->user()->id, NOW(), $role_name_fetch);




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
    public function true_show(Request $request)
    {

        $method = 'Method => ElearningQuestionController => true_show';
        try {

            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $id = $request->id;
            $row = DB::table('elearning_questions_true_false')
                ->select('*')
                ->where('question_id', $id)
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
    public function true_edit($id)
    {
        try {
            $method = 'Method => ElearningQuestionController =>true_edit';
            $id = $this->decryptData($id);
            $row = DB::table('elearning_questions_true_false')
                ->select('*')
                ->where('question_id', $id)
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
    public function true_update(Request $request)
    {
        //

        try {
            $method = 'Method => ElearningQuestionController => true_update';
            $inputArray = $this->decryptData($request->requestData);

            $input = [
                'question_name' => $inputArray['question_name'],
                'question' => $inputArray['question'],
                'answer' => $inputArray['answer'],
                'points' => $inputArray['points'],
                'true_edit' => $inputArray['true_edit'],

            ];

            $update_id = DB::table('elearning_questions_true_false')
                ->where('question_id', $input['true_edit'])
                ->update([
                    'question_name' => $input['question_name'],
                    'question' => $input['question'],
                    'answer' => $input['answer'],
                    'points' => $input['points'],
                    'question_type' => "boolean",
                    'drop_question' => '0',
                    'updated_by' => auth()->user()->id,
                    'updated_at' => NOW()

                ]);
            $this->notifications_insert(null, auth()->user()->id, "T/F Questions Created Successfully", "/elearningquestion");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_questions_true_false', $update_id, 'Update', 'T/F Question Updation', auth()->user()->id, NOW(), $role_name_fetch);

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
    public function quiz_store(Request $request)
    {
        try {
            $method = 'Method => ElearningQuestionController => quiz_store';
            $inputArray = $this->decryptData($request->requestData);

            $settings_id =  $inputArray['quiz_questions'];
            // array_splice( $settings_id . "-" . $question_type);

            $stringsettings_id = implode(",", $settings_id);

            $input = [
                'quiz_name' => $inputArray['quiz_name'],
                'quiz_questions' =>  $stringsettings_id,
                'points' => $inputArray['points'],

            ];

            $update_id =  DB::transaction(function () use ($input) {
                $settings_id = DB::table('elearning_practice_quiz')
                    ->insertGetId([
                        'quiz_name' => $input['quiz_name'],
                        'quiz_questions' => $input['quiz_questions'],
                        'points' => $input['points'],
                        'drop_quiz' => '0',
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
            });

            $this->notifications_insert(null, auth()->user()->id, "Quiz Name Created Successfully", "/elearningquestion");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_practice_quiz', $update_id, 'Create', 'Quiz Creation', auth()->user()->id, NOW(), $role_name_fetch);

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
    public function get_points(Request $request)
    {
        try {
            $method = 'Method => ElearningQuestionController => get_points';
            $userID = auth()->user()->id;
            $inputArray = $this->decryptData($request->requestData);

            $question_ids =  $inputArray['id'];

            $points = 0;

            foreach ($question_ids as $key => $question_id) {
                $question = explode('-', $question_id);
                $question_id = $question[0];
                $question_type = $question[1];

                if ($question_type == "boolean") {

                    $boolean = DB::select("SELECT points  from elearning_questions_true_false where question_id=$question_id");
                    $points_to_add = $boolean[0]->points;
                    $points += $points_to_add;
                } else if ($question_type == "mcq") {
                    $mcq = DB::select("SELECT points  from elearning_questions_mcq  where question_id=$question_id ");
                    $points_to_add = $mcq[0]->points;
                    $points += $points_to_add;
                } else  if ($question_type == "short") {
                    $short = DB::select("SELECT points  from elearning_questions_short_answer  where question_id=$question_id");
                    $points_to_add = $short[0]->points;
                    $points += $points_to_add;
                } else  if ($question_type == "long") {
                    $long = DB::select("SELECT points  from elearning_questions_long_answer  where question_id=$question_id");
                    $points_to_add = $long[0]->points;
                    $points += $points_to_add;
                }
            }
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $points;
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
    public function quiz_show(Request $request)
    {

        $method = 'Method => ElearningQuestionController => quiz_show';
        try {

            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $id = $request->id;
            $row = DB::table('elearning_practice_quiz')
                ->select('*')
                ->where('quiz_id', $id)
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
    public function quiz_edit($id)
    {
        try {
            $method = 'Method => ElearningQuestionController =>quiz_edit';
            $id = $this->decryptData($id);
            $row = DB::table('elearning_practice_quiz')
                ->select('*')
                ->where('quiz_id', $id)
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
    public function quiz_update(Request $request)
    {
        //

        try {
            $method = 'Method => ElearningQuestionController => quiz_update';
            $inputArray = $this->decryptData($request->requestData);
            $settings_id =  $inputArray['quiz_questions'];
            //array_splice($settings_id. "-" .$question_type);

            $stringsettings_id = implode(",", $settings_id);

            $input = [
                'quiz_name' => $inputArray['quiz_name'],
                'quiz_questions' =>  $stringsettings_id,
                'points' => $inputArray['points'],
                'quiz_edit' => $inputArray['quiz_edit'],

            ];

            $update_id = DB::table('elearning_practice_quiz')
                ->where('quiz_id', $input['quiz_edit'])
                ->update([
                    'quiz_name' => $input['quiz_name'],
                    'quiz_questions' => $input['quiz_questions'],
                    'points' => $input['points'],
                    'drop_quiz' => '0',
                    'updated_by' => auth()->user()->id,
                    'updated_at' => NOW()

                ]);

            $this->notifications_insert(null, auth()->user()->id, "Quiz Updated Successfully", "/elearningquestion");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('elearning_practice_quiz', $update_id, 'Update', 'Quiz Updation', auth()->user()->id, NOW(), $role_name_fetch);

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
    public function quiz()
    {
        try {
            $method = 'Method => ElearningQuestionController =>quiz';
            $userID = auth()->user()->id;

            $maxId = DB::select("select quiz_id from elearning_practice_quiz order by quiz_id desc limit 0,1");
            if (empty($maxId)) {
                $serviceResponse = array();
                $serviceResponse['Code'] = 400;
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 1;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                return $sendServiceResponse;
            }
            $max = $maxId[0]->quiz_id;

            $availableQuizzes = DB::select("select quiz_id from elearning_practice_quiz where drop_quiz=0");
            $ethinicQuizzes = DB::select("select quiz_id from elearning_ethnictest where active_flag=0");
            $localAdopQuizzes = DB::select("select quiz_id from elearning_localadaptation where active_flag=0");
            $examQuizzes = DB::select("select quiz_id from elearning_exam where active_flag=0");
            $classsQuizzes = DB::select("select quiz_id from elearning_classes where drop_class=0");

            $usedQuizzess = [];
            foreach ($ethinicQuizzes as $ethinicQuizze) {
                array_splice($usedQuizzess, 1, 0, $ethinicQuizze->quiz_id);
            }
            foreach ($localAdopQuizzes as $localAdopQuizze) {
                array_splice($usedQuizzess, 1, 0, $localAdopQuizze->quiz_id);
            }
            foreach ($examQuizzes as $examQuizze) {
                array_splice($usedQuizzess, 1, 0,  $examQuizze->quiz_id);
            }
            foreach ($classsQuizzes as $classsQuizze) {
                array_splice($usedQuizzess, 1, 0,  $classsQuizze->quiz_id);
            }
            $availableQuizIds = [];
            foreach ($availableQuizzes as $availableQuiz) {
                if (!in_array($availableQuiz->quiz_id, $usedQuizzess)) {
                    array_splice($availableQuizIds, 1, 0, $availableQuiz->quiz_id);
                }
            }
            if (empty($availableQuizIds)) {
                $serviceResponse = array();
                $serviceResponse['Code'] = 400;
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 1;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                return $sendServiceResponse;
            }
            do {
                $randomNumber = rand(1, $max);
            } while (!(in_array($randomNumber, $availableQuizIds)));



            $random_quizid = DB::select("Select quiz_id from elearning_practice_quiz where quiz_id=$randomNumber");
            $random_quizid = $random_quizid[0]->quiz_id;
            $randomQuiz = DB::select("select * from elearning_practice_quiz where quiz_id=$random_quizid");

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
                } else if ($questionType == "mcq") {
                    $questionDetails[$index] = DB::select("select * from elearning_questions_mcq where question_id=$questionId")[0];
                    $choices = explode(",", $questionDetails[$index]->choices);
                    $questionDetails[$index]->choices = $choices;
                } else if ($questionType == "short") {
                    $questionDetails[$index] = DB::select("select * from elearning_questions_short_answer where question_id=$questionId")[0];
                } else if ($questionType == "long") {
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
            $this->notifications_insert(null, auth()->user()->id, "Thanks for Attending the Quiz", "/elearning/quiz/view");
            // $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            // $role_name_fetch = $role_name[0]->role_name;
            // $this->auditLog('elearning_practice_quiz', $response, 'Update', 'Quiz Updation', auth()->user()->id, NOW(), $role_name_fetch);

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
    public function quizresult(Request $request)
    {


        $quizAttendDate = date("Y-m-d H:i:s", time());
        // Authentication

        $userID = auth()->user()->id;
        if ($userID == null) {
            return view('auth.login');
        }
        $id = Crypt::decrypt($request->id);
        $quizDetails = DB::select("Select * from elearning_practice_quiz where quiz_id=$id and drop_quiz=0");
        $qIds = $quizDetails[0]->quiz_questions;
        $quizName = $quizDetails[0]->quiz_name;
        $quizId = $quizDetails[0]->quiz_id;
        $questions = explode(",", $quizDetails[0]->quiz_questions);
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

        $answersArray = $request->answers;
        $answerDetails = [];
        $answerIndex = 0;
        $totalAvailablePoints = 0;
        $totalPointsEarned = 0;
        foreach ($answersArray as $answerArray) {
            $questionNUmber = $answerArray["questionId"];
            $questionType = $answerArray["questionType"];
            $answer = strtolower($answerArray["answer"]);
            if ($questionType == "boolean") {
                $thisQuestion = DB::select("select * from elearning_questions_true_false where question_id=$questionNUmber");
                $correctAnswer =  $thisQuestion[0]->answer;
                $points =  $thisQuestion[0]->points;
                $totalAvailablePoints = $totalAvailablePoints + $points;
                if ($answer == $correctAnswer) {
                    $answerDetails[$answerIndex] = [
                        'questionId' => $questionNUmber,
                        'questionType' => $questionType,
                        'answerGiven' => $answer,
                        'answerStatus' => '1',
                        'correctAnswer' => $correctAnswer,
                        'pointEarned' => $points
                    ];
                    $totalPointsEarned = $totalPointsEarned + $points;
                } else {
                    $answerDetails[$answerIndex] = [
                        'questionId' => $questionNUmber,
                        'questionType' => $questionType,
                        'answerGiven' => $answer,
                        'answerStatus' => '0',
                        'correctAnswer' => $correctAnswer,
                        'pointEarned' => '0'
                    ];
                }
                $answerIndex++;
            } elseif ($questionType == "mcq") {
                $thisQuestion = DB::select("select * from elearning_questions_mcq where question_id=$questionNUmber");
                $correctChoices = explode(",", $thisQuestion[0]->correct_choices);
                $answerGiven = explode(",", $answer);
                unset($answerGiven[0]);
                $answerGiven = array_values($answerGiven);
                $availablePoints = $thisQuestion[0]->points;
                $totalAvailablePoints = $totalAvailablePoints + $availablePoints;
                $pointsEarned = 0;
                $pointPerChoice = $availablePoints / count($correctChoices);
                $answerStatusPair = [];
                $answerStatusIndex = 0;
                foreach ($answerGiven as $answerChoice) {
                    if (in_array($answerChoice, $correctChoices)) {
                        $pointsEarned = $pointsEarned + $pointPerChoice;
                        $answerStatusPair[$answerStatusIndex] =  $answerChoice . ", on";
                        $answerStatusIndex++;
                    } else {
                        $answerStatusPair[$answerStatusIndex] =  $answerChoice . ", off";
                        $answerStatusIndex++;
                    }
                }
                $totalPointsEarned = $totalPointsEarned + $pointsEarned;
                $answerDetails[$answerIndex] = [
                    'questionId' => $questionNUmber,
                    'questionType' => $questionType,
                    'answerGiven' => $answerGiven,
                    'answerStatus' => $answerStatusPair,
                    'correctAnswer' => $correctChoices,
                    'pointEarned' => $pointsEarned
                ];
                $answerIndex++;
            } elseif ($questionType == "short") {
                $thisQuestion = DB::select("select * from elearning_questions_short_answer where question_id=$questionNUmber");
                $keywords = explode(",", $thisQuestion[0]->keywords);

                $availablePoints = $thisQuestion[0]->points;
                $totalAvailablePoints = $totalAvailablePoints + $availablePoints;
                $pointsEarned = 0;
                $pointPerkeyword = $availablePoints / count($keywords);
                $answerStatus = "";
                $keyword_count = count($keywords);
                $keyword_count_earned_full = 0;
                $keyword_count_earned_partial = 0;


                foreach ($keywords as $key => $keyword) {
                    if (str_contains($answer, $keyword)) {
                        $keyword_count_earned_full++;
                        $pointsEarned = $availablePoints;
                        $answerStatus = "Full";
                    } elseif (str_contains($answer, $keywords[0])) {
                        $keyword_count_earned_partial++;
                        $pointsEarned = $pointPerkeyword;
                        $answerStatus = "Partial";
                    }

                    # code...
                }
                if ($keyword_count_earned_full == $keyword_count) {
                    $pointsEarned = $availablePoints;
                    $answerStatus = "Full";
                } elseif ($keyword_count_earned_partial == $keyword_count) {
                    $pointsEarned = $pointPerkeyword;
                    $answerStatus = "Partial";
                } else {
                    $pointsEarned = 0;
                    $answerStatus = "none";
                }
                // if (str_contains($answer, $keywords[0]) && str_contains($answer, $keywords[1])) {
                //     $pointsEarned = $availablePoints;
                //     $answerStatus = "Full";
                // } elseif (str_contains($answer, $keywords[0]) || str_contains($answer, $keywords[1])) {
                //     $pointsEarned = $pointPerkeyword;
                //     $answerStatus = "Partial";
                // } else {
                //     $pointsEarned = 0;
                //     $answerStatus = "none";
                // }
                $totalPointsEarned = $totalPointsEarned + $pointsEarned;
                $answerDetails[$answerIndex] = [
                    'questionId' => $questionNUmber,
                    'questionType' => $questionType,
                    'answerGiven' => $answer,
                    'answerStatus' => $answerStatus,
                    'correctAnswer' => $keywords,
                    'pointEarned' => $pointsEarned
                ];
                $answerIndex++;
            } elseif ($questionType == "long") {
                $thisQuestion = DB::select("select * from elearning_questions_long_answer where question_id=$questionNUmber");
                $keywords = explode(",", $thisQuestion[0]->keywords);
                $availablePoints = $thisQuestion[0]->points;
                $totalAvailablePoints = $totalAvailablePoints + $availablePoints;
                $pointsEarned = 0;
                $pointPerkeyword = $availablePoints / count($keywords);
                $answerStatus = "";
                $keyword_count = count($keywords);
                $keyword_count_earned_full = 0;
                $keyword_count_earned_partial = 0;
                // $pointPerkeyword = $availablePoints / count($keywords);
                // $answerStatus = "";
                foreach ($keywords as $key => $keyword) {
                    if (str_contains($answer, $keyword)) {
                        $keyword_count_earned_full++;
                        $pointsEarned = $availablePoints;
                        $answerStatus = "Full";
                    } elseif (str_contains($answer, $keywords[0])) {
                        $keyword_count_earned_partial++;
                        $pointsEarned = $pointPerkeyword;
                        $answerStatus = "Partial";
                    }

                    # code...
                }
                if ($keyword_count_earned_full == $keyword_count) {
                    $pointsEarned = $availablePoints;
                    $answerStatus = "Full";
                } elseif ($keyword_count_earned_partial == $keyword_count) {
                    $pointsEarned = $pointPerkeyword;
                    $answerStatus = "Partial";
                } else {
                    $pointsEarned = 0;
                    $answerStatus = "none";
                }
                // if (str_contains($answer, $keywords[0]) && str_contains($answer, $keywords[1])) {
                //     $pointsEarned = $availablePoints;
                //     $answerStatus = "Full";
                // } elseif (str_contains($answer, $keywords[0]) || str_contains($answer, $keywords[1])) {
                //     $pointsEarned = $pointPerkeyword;
                //     $answerStatus = "Partial";
                // } else {
                //     $pointsEarned = 0;
                //     $answerStatus = "none";
                // }


                $totalPointsEarned = $totalPointsEarned + $pointsEarned;
                $answerDetails[$answerIndex] = [
                    'questionId' => $questionNUmber,
                    'questionType' => $questionType,
                    'answerGiven' => $answer,
                    'answerStatus' => $answerStatus,
                    'correctAnswer' => $keywords,
                    'pointEarned' => $pointsEarned
                ];
                $answerIndex++;
            }
        }

        $data = [
            'quizId' => $quizId,
            'quizName' => $quizName,
            'qIds' => $qIds,
            'questionDetails' => $questionDetails,
            'answersArray' => $answersArray,
            'answerDetails' => $answerDetails,
            'totalAvailablePoints' => $totalAvailablePoints,
            'totalPointsEarned' => $totalPointsEarned,
        ];

        $questionIds = $quizDetails[0]->quiz_questions;
        $questionScoresArray = [];
        foreach ($answerDetails as $answerDetail) {
            array_splice($questionScoresArray, 1, 0, $answerDetail["pointEarned"]);
            if (gettype($answerDetail["answerGiven"]) == "array") {
                $answer_given = implode(",", $answerDetail["answerGiven"]);
            } else {
                $answer_given = $answerDetail["answerGiven"];
            }
            if (gettype($answerDetail["answerStatus"]) == "array") {
                $answer_status = implode(",", $answerDetail["answerStatus"]);
            } else {
                $answer_status = $answerDetail["answerStatus"];
            }
            if (gettype($answerDetail["correctAnswer"]) == "array") {
                $correct_answer = implode(",", $answerDetail["correctAnswer"]);
            } else {
                $correct_answer = $answerDetail["correctAnswer"];
            }
            DB::table('elearning_question_results')
                ->insert([
                    'user_id' => $userID,
                    'question_id' => $answerDetail["questionId"],
                    'question_type' => $answerDetail["questionType"],
                    'answer_given' => $answer_given,
                    'answer_status' => $answer_status,
                    'correct_answer' => $correct_answer,
                    'scores_earned' => $answerDetail["pointEarned"],
                    'quiz_date' => $quizAttendDate,
                ]);
        }
        $questionScores = implode(",", $questionScoresArray);


        $update_id=DB::table('elearning_quiz_results')
            ->insert([
                'user_id' => "$userID",
                'quiz_id' => "$quizId",
                'quiz_name' => "$quizName",
                'questions_ids' => "$questionIds",
                'questions_scores' => "$questionScores",
                'total_scores' => "$totalAvailablePoints",
                'scores_earned' => "$totalPointsEarned",
                'quiz_date' => "$quizAttendDate",
            ]);
        $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
        $role_name_fetch = $role_name[0]->role_name;
        $this->auditLog('elearning_quiz_results', $update_id, 'Results', 'Quiz results', auth()->user()->id, NOW(), $role_name_fetch);

        $serviceResponse = array();
        $serviceResponse['Code'] = config('setting.status_code.success');
        $serviceResponse['Message'] = config('setting.status_message.success');
        $serviceResponse['Data'] =  $data;
        $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
        $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
        return $sendServiceResponse;
    }
}
