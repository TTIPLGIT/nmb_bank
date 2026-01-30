<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AIController extends BaseController
{
    public function ai_course_list(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if ($menus == "401") {
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        $method = "GET";
        $gatewayURL = config('setting.api_gateway_url') . '/ai/course_list';

        $response = json_decode($this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method));
        if ($response->Status == 200 && $response->Success) {
            $objData = json_decode($this->decryptData($response->Data));
            $parant_data = json_decode(json_encode($objData->Data), true);

            // dd($levels);
        }
        //    dd(json_decode($response->Data));
        // dd($levels);

        return view("AI.course_list", compact('screens', 'modules'));
    }

    public function ai_course_create(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $user_id = $request->session()->get("userID");
        $method = 'Method => vbpfeedbackController => create';


        $gatewayURL = config('setting.api_gateway_url') . '/ai/ai_course_create';

        $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

        $response = json_decode($response);

        if ($response->Status == 200 && $response->Success) {
            $objData = json_decode($this->decryptData($response->Data));
            if ($objData->Code == 200) {
                $parant_data = json_decode(json_encode($objData->Data), true);
                $rows =  $parant_data;
                $alter_name = $this->get_user_role();
                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                $permission = $this->FillScreensByUser();

                return view('AI.course_create', compact('rows', 'menus', 'screens', 'modules'));
            }
            if ($objData->Code == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
        }
    }
    public function ai_createcourse(Request $request)
    {
        $method = 'Method => AIController => ai_createcourse';


        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $data = (object) [
                'category'           => $request->course_category_id,
                'role'               => $request->role,
                'designation'        => $request->designation_id,
                'course_name'        => $request->course_name,
                'course_description' => $request->course_description,
                'course_type'        => $request->course_type,
                'class_count'        => (int) $request->class_count,
                'video_duration'     => $request->course_duration,
            ];



            $gatewayURL = 'http://20.164.0.23:3300/create-course/';

            $response = $this->AIserviceRequest($gatewayURL, 'POST', $data, $method);
            $response = is_string($response)
                ? json_decode($response, true)
                : $response;
            // dd($response['classes']);
            // Start
            DB::beginTransaction();

            try {


                $courseId = DB::table('ai_course_response')->insertGetId([
                    'course_name'               => $response['course_name'],
                    'course_description'        => $response['course_description'],
                    'category'                  => $response['category'],
                    'role'                      => $response['role'],
                    'designation'               => $response['designation'],
                    'course_type'               => $response['course_type'],
                    'course_duration'           => $response['course_duration'],
                    'class_count'               => count($response['classes']),
                    'completion_points_logic'   => $response['completion_points_logic'],
                    'course_banner_prompt'      => $response['course_banner_prompt'],
                    'course_banner_url'         => $response['course_banner_url'],
                    'course_introduction'       => $response['course_introduction'],
                    'certification_html'        => $response['certification_html'],
                    'final_exam'                => json_encode($response['final_exam'], JSON_UNESCAPED_UNICODE),
                ]);


                foreach ($response['classes'] as $index => $class) {
                    DB::table('ai_course_response_classes')->insert([
                        'ai_course_response_id' => $courseId,
                        'class_order'           => $index + 1,
                        'class_name'            => $class['class_name'],
                        'class_description'     => $class['class_description'],
                        'target_video_duration' => $class['target_video_duration'],
                        'resource_type'         => $class['resource_type'],
                        'resource_content'      => $class['resource_content'],
                        'estimated_duration'    => $class['estimated_duration'],
                        'video_url'             => $class['video_url'],
                        'video_slides'          => json_encode($class['video_slides'], JSON_UNESCAPED_UNICODE),
                        'quiz'                  => json_encode($class['quiz'], JSON_UNESCAPED_UNICODE),
                    ]);
                }

                DB::commit();
                // return $courseId;
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
            // End 
            if (!$response || isset($response['error'])) {
                return "Invalid response from API";
            }


            // ✅ If response is string, decode it
            if (is_string($response)) {
                $course = json_decode($response, true);
            } else {
                $course = $response; // already array
            }


            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];

            return view('AI.cource_preview', compact('menus', 'screens', 'modules', 'course'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function ai_course_store(Request $request)
    {
        // dd('jii');

        $classes = DB::select("select * from ai_course_response_classes");
        //
         $class = DB::table('elearning_classes')
            ->insertGetId([
                'class_name' => $classes[0]->class_name,
                'resource_name' => $classes[0]->resource_name,
                // 'resource_path' => $input['resource_path'],
                'class_duration' => $classes[0]->target_video_duration,
                'class_format' => 'mp4',
                'class_description' => $classes[0]->class_description,
                // 'quiz_id' => $quizID,
                'class_quiz' => 'yes',
            ]);

        // $quizs = $classes[0]->quiz;
        $quizs = json_decode($classes[0]->quiz, true);
        // $class = json_decode($classes[0]->classes, true);
        // dd($quizs);
        $quiz_questions = [];
        $points = 0;
        foreach ($quizs['long'] ?? [] as $q) {
            $quizLong = DB::table('elearning_questions_long_answer')->insertGetId([
                'question_name' => substr($q['question_text'], 0, 100),
                'question'      => $q['question_text'],
                'keywords'      => json_encode($q['answer']),
                'points'        => 10,
                'question_type' => 'long',
                'drop_question' => '0',
                // 'created_by'    => auth()->user()->id,
                'created_at'    => now()
            ]);
            $quiz_questions[] = $quizLong . '-long';
            $points = $points + 10;
            // 6-long
        }

        foreach ($quizs['mcq'] ?? [] as $q) {
            $quizMCQ = DB::table('elearning_questions_mcq')->insertGetId([
                'question_name'    => substr($q['question_text'], 0, 100),
                'question'         => $q['question_text'],
                'choices'          => json_encode($q['options']),
                'correct_choices'  => $q['correct_option_id'],
                'points'           => 5,
                'question_type'    => 'mcq',
                'drop_question'    => '0',
                // 'created_by'       => auth()->user()->id,
                'created_at'       => now()
            ]);
            $quiz_questions[] = $quizMCQ . '-mcq';
            $points = $points + 5;
        }

        foreach ($quizs['short'] ?? [] as $q) {
            $quizShort = DB::table('elearning_questions_short_answer')->insertGetId([
                'question_name' => substr($q['question_text'], 0, 100),
                'question'      => $q['question_text'],
                'keywords'      => $q['answer'],
                'points'        => 5,
                'question_type' => 'short',
                'drop_question' => '0',
                // 'created_by'    => auth()->user()->id,
                'created_at'    => now()
            ]);
            $quiz_questions[] = $quizShort . '-short';
            $points = $points + 5;
        }

        foreach ($quizs['short'] ?? [] as $q) {
            $boolean = DB::table('elearning_questions_true_false')
                ->insertGetId([
                    'question_name' => substr($q['question_text'], 0, 100),
                    'question' => $q['question_text'],
                    'answer' => strtolower($q['answer']) === 'True' ? 'on' : 'off', //$q['answer'],
                    'points' => 5,
                    'question_type' => "boolean",
                    'drop_question' => '0',
                    // 'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);
        }

        $quizID = DB::table('elearning_practice_quiz')
            ->insertGetId([
                'quiz_name' => 'Quiz-001',
                'quiz_questions' => implode(",", $quiz_questions),
                'points' => $points,
                'drop_quiz' => '0',
                'evaluation' => 1,
                // 'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

       
 $class = DB::table('elearning_classes')
            ->update([
                // 'class_name' => $classes[0]->class_name,
                // 'resource_name' => $classes[0]->resource_name,
                // // 'resource_path' => $input['resource_path'],
                // 'class_duration' => $classes[0]->target_video_duration,
                // 'class_format' => 'mp4',
                // 'class_description' => $classes[0]->class_description,
                'quiz_id' => $quizID,
                // 'class_quiz' => 'yes',
            ]);

    }
    public function adaptive_learning_list(Request $request)
    {
        $method = 'Method=> governmentInstructionController => taskSubmission';
        try {
            $user_id = $request->session()->get("userID");



            $gatewayURL = config('setting.api_gateway_url') . '/adaptive/learning/list';
            $response = json_decode($this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method));

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data;
                    $alter_name = $this->get_user_role();
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $permission = $this->FillScreensByUser();
                    return view('AI.adaptive_learning', compact('menus', 'screens', 'modules', 'rows'));
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function adaptive_learning(Request $request)
    {


        $method = 'Method => AIController => adaptive_learning';
        try {
            $data = array();
            $data['user_id'] = $request->user_name;
            $data['course_id'] = $request->course_name;



            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;
            $gatewayURL = 'http://20.164.0.23:3300/adaptive/decide-from-db/' . $data['user_id'] . '/' . $data['course_id'];

            $response = $this->AIserviceRequest($gatewayURL, 'GET', '', $method);
            $response1 = json_decode($response, true);
            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            if (!$response1) {
                return "Invalid JSON response from API";
            }

            if ($response1['status'] == 'success') {

                return view('AI.adaptive_learning_result', array_merge(
                    ['data' => $response1],
                    compact('menus', 'screens', 'modules')
                ));
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function predictive_analysis(Request $request)
    {
        $method = 'Method=> AIController => taskSubmission';
        try {
            $user_id = $request->session()->get("userID");


            $gatewayURL = 'http://20.164.0.23:3300/ai/predictive-analysis/run';
            $response = $this->AIserviceRequest($gatewayURL, 'POST', '', $method);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data;
                    $alter_name = $this->get_user_role();
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $permission = $this->FillScreensByUser();
                    return view('AI.predictive_analysis', compact('menus', 'screens', 'modules', 'rows'));
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
}
