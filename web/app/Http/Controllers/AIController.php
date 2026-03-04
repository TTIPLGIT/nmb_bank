<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Peopleaps\Scorm\Manager\ScormManager;
use Peopleaps\Scorm\Exception\InvalidScormArchiveException;
use Peopleaps\Scorm\Model\ScormModel;

class AIController extends BaseController
{
    public function ai_course_list(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $menus = $this->FillMenu();
        $ai_courses = [];
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
            $ai_courses =  $parant_data['ai_courses'];
           
        }
        //    dd(json_decode($response->Data));
        // dd($levels);

        return view("AI.course_list", compact('screens', 'modules','ai_courses'));
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
                'course_type'        => "",
                'class_count'        => (int) $request->class_count,
                'video_duration'     => $request->course_duration,
            ];



            $gatewayURL = config('setting.AI_service_url') . '/create-course/';

            $response = $this->AIserviceRequest($gatewayURL, 'POST', $data, $method);
            $response = is_string($response)
                ? json_decode($response, true)
                : $response;
            // dd($response);
            // Start
            // $filePath = 'C:\Apache24\htdocs\nmb_bank\web\storage\app\static_course_data.json';
            //     $jsonContent = file_get_contents($filePath);
            //     $response = json_decode($jsonContent, true);
           
    
    $result = [
        "course_name" => $response['course_name'],
        "classes" => []
    ];
    
    foreach ($response['classes'] as $class) {
        $transformedClass = [
            "class_name" => $class['class_name'],
            "slides" => []
        ];
        
        foreach ($class['video_slides'] as $slide) {
            $transformedSlide = [
                "title" => $slide['title'],
                "visual_text" => $slide['visual_text'],
                "voiceover_script" => $slide['voiceover_script']
            ];
            
            $transformedClass['slides'][] = $transformedSlide;
        }
        
        $result['classes'][] = $transformedClass;
    }
    
   

            $gatewayURL = config('setting.AI_service_url') . '/generate-course-video/';

            // Method for the API request
            $method = 'POST';

            // Send the data to the API
            $apiResponse = $this->AIServiceRequest($gatewayURL, 'POST', $result,$method);

            // Process the response
            $response2 = is_string($apiResponse) 
                ? json_decode($apiResponse, true) 
                : $apiResponse;

            // Debug/check the response
           
                if ($response === null) {
                    // Handle JSON parsing error
                    $error = json_last_error_msg();
                    // Error handling logic
                }
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
                      'category_id'           => $request->course_category_id,
                        'role_id'               => $request->role,
                        'designation_id'        => $request->designation_id,
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
                        'task_id' => $response2['tasks'][$index]['task_id'],
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

//     public function ai_course_store(Request $request)
//     {
        

//         $classes = DB::select("select * from ai_course_response_classes");
//         //
//          $class = DB::table('elearning_classes')
//             ->insertGetId([
//                 'class_name' => $classes[0]->class_name,
//                 'resource_name' => $classes[0]->resource_name,
//                 // 'resource_path' => $input['resource_path'],
//                 'class_duration' => $classes[0]->target_video_duration,
//                 'class_format' => 'mp4',
//                 'class_description' => $classes[0]->class_description,
//                 // 'quiz_id' => $quizID,
//                 'class_quiz' => 'yes',
//             ]);

//         // $quizs = $classes[0]->quiz;
//         $quizs = json_decode($classes[0]->quiz, true);
//         // $class = json_decode($classes[0]->classes, true);
//         // dd($quizs);
//         $quiz_questions = [];
//         $points = 0;
//         foreach ($quizs['long'] ?? [] as $q) {
//             $quizLong = DB::table('elearning_questions_long_answer')->insertGetId([
//                 'question_name' => substr($q['question_text'], 0, 100),
//                 'question'      => $q['question_text'],
//                 'keywords'      => json_encode($q['answer']),
//                 'points'        => 10,
//                 'question_type' => 'long',
//                 'drop_question' => '0',
//                 // 'created_by'    => auth()->user()->id,
//                 'created_at'    => now()
//             ]);
//             $quiz_questions[] = $quizLong . '-long';
//             $points = $points + 10;
//             // 6-long
//         }

//         foreach ($quizs['mcq'] ?? [] as $q) {
//             $quizMCQ = DB::table('elearning_questions_mcq')->insertGetId([
//                 'question_name'    => substr($q['question_text'], 0, 100),
//                 'question'         => $q['question_text'],
//                 'choices'          => json_encode($q['options']),
//                 'correct_choices'  => $q['correct_option_id'],
//                 'points'           => 5,
//                 'question_type'    => 'mcq',
//                 'drop_question'    => '0',
//                 // 'created_by'       => auth()->user()->id,
//                 'created_at'       => now()
//             ]);
//             $quiz_questions[] = $quizMCQ . '-mcq';
//             $points = $points + 5;
//         }

//         foreach ($quizs['short'] ?? [] as $q) {
//             $quizShort = DB::table('elearning_questions_short_answer')->insertGetId([
//                 'question_name' => substr($q['question_text'], 0, 100),
//                 'question'      => $q['question_text'],
//                 'keywords'      => $q['answer'],
//                 'points'        => 5,
//                 'question_type' => 'short',
//                 'drop_question' => '0',
//                 // 'created_by'    => auth()->user()->id,
//                 'created_at'    => now()
//             ]);
//             $quiz_questions[] = $quizShort . '-short';
//             $points = $points + 5;
//         }

//         foreach ($quizs['short'] ?? [] as $q) {
//             $boolean = DB::table('elearning_questions_true_false')
//                 ->insertGetId([
//                     'question_name' => substr($q['question_text'], 0, 100),
//                     'question' => $q['question_text'],
//                     'answer' => strtolower($q['answer']) === 'True' ? 'on' : 'off', //$q['answer'],
//                     'points' => 5,
//                     'question_type' => "boolean",
//                     'drop_question' => '0',
//                     // 'created_by' => auth()->user()->id,
//                     'created_at' => NOW()
//                 ]);
//         }

//         $quizID = DB::table('elearning_practice_quiz')
//             ->insertGetId([
//                 'quiz_name' => 'Quiz-001',
//                 'quiz_questions' => implode(",", $quiz_questions),
//                 'points' => $points,
//                 'drop_quiz' => '0',
//                 'evaluation' => 1,
//                 // 'created_by' => auth()->user()->id,
//                 'created_at' => NOW()
//             ]);

       
//  $class = DB::table('elearning_classes')
//             ->update([
//                 // 'class_name' => $classes[0]->class_name,
//                 // 'resource_name' => $classes[0]->resource_name,
//                 // // 'resource_path' => $input['resource_path'],
//                 // 'class_duration' => $classes[0]->target_video_duration,
//                 // 'class_format' => 'mp4',
//                 // 'class_description' => $classes[0]->class_description,
//                 'quiz_id' => $quizID,
//                 // 'class_quiz' => 'yes',
//             ]);

//     }

public function ai_course_store(Request $request)
{
    $method = 'Method => AIController => ai_course_store';

    try {
        $user_id = $request->session()->get("userID");
        if (!$user_id) {
            return view('auth.login');
        }

        $selectedQuestions = json_decode($request->selected_questions, true);
        $filteredCourseData = json_decode($request->course_data, true);
       
        DB::beginTransaction();

        try {
            /* =====================================================
               1. CREATE COURSE
            ===================================================== */
            
            $multipletags = implode(", ", $filteredCourseData['tags']);
            $multipleskills = implode(", ", $filteredCourseData['skills_required']);
            $multiplegainskills = implode(", ", $filteredCourseData['skills_gained']);
            $courseID = DB::table('elearning_courses')->insertGetId([
                'course_name'        => $filteredCourseData['course_name'],
                'course_description' => $filteredCourseData['course_description'],
                'course_tags'               => $multipletags,
                'course_skills_required'    => $multipleskills,
                'course_gain_skills'      => $multiplegainskills,
                'drop_course'        => 0,
               
            ], 'course_id');
            
            // Update AI response table with course ID if needed
            DB::table('ai_course_response')
                ->where('course_name', $filteredCourseData['course_name'])
                ->orderBy('id', 'desc')
                ->limit(1)
                ->update([
                    'course_id' => $courseID,
                    'updated_at' => now()
                ]);

             DB::table('ai_course_response')
                ->where('course_id', $courseID)
                ->update([
                    'is_submitted' => '1',
                 
                    
                ]);

            /* =====================================================
               2. CREATE CLASSES + QUIZZES
            ===================================================== */
            $classIds = [];
            $totalCoursePoints = 0;

              $ai_course_response = DB::table('ai_course_response')
                ->where('course_id', $courseID)
                ->orderBy('id', 'desc')
                ->first();
           
            foreach ($filteredCourseData['classes'] as $classIndex => $class) {
                $quizData = $class['quiz'] ?? [];
                $quiz_questions = [];
                $points = 0;

                /* ---------- LONG QUESTIONS ---------- */
                foreach ($quizData['long'] ?? [] as $qIndex => $q) {
                    $keywords = implode(',', $q['keywords']);
                    $qid = DB::table('elearning_questions_long_answer')->insertGetId([
                        'question_name' => substr($q['question_text'], 0, 100),
                        'question'      => $q['question_text'],
                        'keywords'      => $keywords,
                        'points'        => $q['points'],
                        'question_type' => 'long',
                        'drop_question' => 0,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ]);

                    $quiz_questions[] = $qid . '-long';
                    $points += $q['points'];
                    $totalCoursePoints += $q['points'];
                }

                /* ---------- MCQ QUESTIONS ---------- */
                foreach ($quizData['mcq'] ?? [] as $qIndex => $q) {
                    $choices = array_column($q['options'], 'text');
                    $choicesText = implode(', ', $choices);
                    $qid = DB::table('elearning_questions_mcq')->insertGetId([
                        'question_name'    => substr($q['question_text'], 0, 100),
                        'question'         => $q['question_text'],
                       
                        'choices'     => $choicesText,
                        'correct_choices'  => $q['correct_option_id'],
                        'points'           => $q['points'],
                        'question_type'    => 'mcq',
                        'drop_question'    => 0,
                        'created_at'       => now(),
                        'updated_at'       => now(),
                    ]);

                    $quiz_questions[] = $qid . '-mcq';
                    $points += $q['points'];
                    $totalCoursePoints += $q['points'];
                }

                /* ---------- SHORT QUESTIONS ---------- */
                foreach ($quizData['short'] ?? [] as $qIndex => $q) {
                    $keywords = implode(',', $q['keywords']);
                    $qid = DB::table('elearning_questions_short_answer')->insertGetId([
                        'question_name' => substr($q['question_text'], 0, 100),
                        'question'      => $q['question_text'],
                        'keywords'      => $keywords,
                        'points'        => $q['points'],
                        'question_type' => 'short',
                        'drop_question' => 0,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ]);

                    $quiz_questions[] = $qid . '-short';
                    $points += $q['points'];
                    $totalCoursePoints += $q['points'];
                }

                /* ---------- TRUE / FALSE ---------- */
                foreach ($quizData['true_false'] ?? [] as $qIndex => $q) {
                    $qid = DB::table('elearning_questions_true_false')->insertGetId([
                        'question_name' => substr($q['question_text'], 0, 100),
                        'question'      => $q['question_text'],
                        'answer'        => strtolower($q['answer']) === 'true' ? 'on' : 'off',
                        'points'        => $q['points'],
                        'question_type' => 'boolean',
                        'drop_question' => 0,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ]);

                    $quiz_questions[] = $qid . '-boolean';
                    $points += $q['points'];
                    $totalCoursePoints += $q['points'];
                }

                $quizID = null;
                if (!empty($quiz_questions)) {
                    $quizID = DB::table('elearning_practice_quiz')->insertGetId([
                        'quiz_name'      => 'Quiz-' . ($classIndex + 1),
                        'quiz_questions' => implode(',', $quiz_questions),
                        'points'         => $points,
                        'drop_quiz'      => 0,
                        'evaluation'     => 1,
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ]);
                }

                $classID = DB::table('elearning_classes')->insertGetId([
                    'class_name'        => $class['class_name'],
                    'resource_name'     => $class['class_name'],
                    'class_duration'    => $class['estimated_duration'] ?? $class['target_video_duration'] ?? '30 mins',
                    'class_format'      => 'mp4',
                    'class_description' => $class['class_description'],
                    'quiz_id'           => $quizID,
                    'class_quiz'        => $quizID ? 'yes' : 'no',
                    'drop_class'        => 0,
                  
                ]);
                // Update AI response classes table with actual LMS class ID
                DB::table('ai_course_response_classes')
                    ->where('ai_course_response_id', $ai_course_response->id)
                    ->where('class_name', $class['class_name'])
                    ->update([
                        'class_id'   => $classID,
                        'updated_at' => now()
                    ]);

                $classIds[] = $classID;
            }
            
            /* =====================================================
               3. CREATE FINAL EXAM
            ===================================================== */
            $finalExamQuestions = [];
            $finalExamPoints = 0;
            
            if (isset($filteredCourseData['final_exam'])) {
                $finalExamData = $filteredCourseData['final_exam'];
                
                /* ---------- LONG QUESTIONS ---------- */
                foreach ($finalExamData['long'] ?? [] as $qIndex => $q) {
                    $keywords = implode(',', $q['keywords']);
                    $qid = DB::table('elearning_questions_long_answer')->insertGetId([
                        'question_name' => substr($q['question_text'], 0, 100),
                        'question'      => $q['question_text'],
                        'keywords'      => $keywords,
                        'points'        => $q['points'],
                        'question_type' => 'long',
                        'drop_question' => 0,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ]);

                    $finalExamQuestions[] = $qid . '-long';
                    $finalExamPoints += $q['points'];
                    $totalCoursePoints += $q['points'];
                }

                /* ---------- MCQ QUESTIONS ---------- */
                foreach ($finalExamData['mcq'] ?? [] as $qIndex => $q) {
                    $choices = array_column($q['options'], 'text');
                     $choicesText = implode(', ', $choices);
                    $qid = DB::table('elearning_questions_mcq')->insertGetId([
                        'question_name'    => substr($q['question_text'], 0, 100),
                        'question'         => $q['question_text'],
                        'choices'          => $choicesText,
                        'correct_choices'  => $q['correct_option_id'],
                        'points'           => $q['points'],
                        'question_type'    => 'mcq',
                        'drop_question'    => 0,
                        'created_at'       => now(),
                        'updated_at'       => now(),
                    ]);

                    $finalExamQuestions[] = $qid . '-mcq';
                    $finalExamPoints += $q['points'];
                    $totalCoursePoints += $q['points'];
                }

                /* ---------- SHORT QUESTIONS ---------- */
                foreach ($finalExamData['short'] ?? [] as $qIndex => $q) {
                    $keywords = implode(',', $q['keywords']);
                    $qid = DB::table('elearning_questions_short_answer')->insertGetId([
                        'question_name' => substr($q['question_text'], 0, 100),
                        'question'      => $q['question_text'],
                        'keywords'      => $keywords,
                        'points'        => $q['points'],
                        'question_type' => 'short',
                        'drop_question' => 0,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ]);

                    $finalExamQuestions[] = $qid . '-short';
                    $finalExamPoints += $q['points'];
                    $totalCoursePoints += $q['points'];
                }

                /* ---------- TRUE / FALSE ---------- */
                foreach ($finalExamData['true_false'] ?? [] as $qIndex => $q) {
                    $qid = DB::table('elearning_questions_true_false')->insertGetId([
                        'question_name' => substr($q['question_text'], 0, 100),
                        'question'      => $q['question_text'],
                        'answer'        => strtolower($q['answer']) === 'true' ? 'on' : 'off',
                        'points'        => $q['points'],
                        'question_type' => 'boolean',
                        'drop_question' => 0,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ]);

                    $finalExamQuestions[] = $qid . '-boolean';
                    $finalExamPoints += $q['points'];
                    $totalCoursePoints += $q['points'];
                }
            }

            $finalExamID = null;
            if (!empty($finalExamQuestions)) {
                $finalExamID = DB::table('elearning_practice_quiz')->insertGetId([
                    'quiz_name'      => 'Final Exam - ' . $filteredCourseData['course_name'],
                    'quiz_questions' => implode(',', $finalExamQuestions),
                    'points'         => $finalExamPoints,
                    'drop_quiz'      => 0,
                    'evaluation'     => 1,
                    
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);

                 $finalExamID = DB::table('elearning_exam')->insertGetId([
                    'exam_name'      => 'Final Exam - ' . $filteredCourseData['course_name'],
                    'quiz_id' => $finalExamID,
                    'user_category'         => '42',
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);

                 DB::table('elearning_courses')
                ->where('course_id', $courseID)
                ->update([
                    'exam_id' => $finalExamID,
                 
                    
                ]);
            }

           
                

            /* =====================================================
               4. UPDATE COURSE WITH CLASSES AND FINAL EXAM
            ===================================================== */
            DB::table('elearning_courses')
                ->where('course_id', $courseID)
                ->update([
                    'course_classes' => implode(',', $classIds),
                    'role_id' => $ai_course_response->role_id,
                    'designation_id' => $ai_course_response->designation_id,
                    'course_category'    => $ai_course_response->category_id,
                 
                    
                ]);

           

            DB::commit();

            return redirect()
                ->route('ai_course_list')
                ->with('success', 'Course "' . $filteredCourseData['course_name'] . '" created successfully with ' . 
                       count($filteredCourseData['classes']) . ' classes and final exam!');

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

    } catch (\Exception $exc) {
        return $this->sendLog(
            $method,
            $exc->getCode(),
            $exc->getMessage(),
            $exc->getTrace()[0]['line'],
            $exc->getTrace()[0]['file']
        );
    }
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
            $gatewayURL = config('setting.AI_service_url') . '/adaptive/decide-from-db/' . $data['user_id'] . '/' . $data['course_id'];

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
    $method = 'Method=> AIController => predictive_analysis';
    
    try {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        
        // Prepare request body exactly like in your example
        $data = (object) [
            'user_id' => (int)$user_id
        ];

        $gatewayURL = config('setting.AI_service_url') . 'ai/predictive-analysis/run';

        // Make the API call
        $response = $this->AIserviceRequest($gatewayURL, 'POST', $data, $method);
        
        // Decode the response
        $response = is_string($response)
            ? json_decode($response, true)
            : $response;
            
        // Check if response is valid
        if (!$response || isset($response['error'])) {
            // Return empty data structure if API fails
            $processedData = $this->getEmptyDataStructure();
            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            
            return view('AI.predictive_analysis', compact('menus', 'screens', 'modules', 'processedData'))
                ->with('error', 'Invalid response from API');
        }
        
        // Process the response data
        $processedData = $this->processRiskAnalysisData($response);
        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view('AI.predictive_analysis', compact('menus', 'screens', 'modules', 'processedData'));
        
    } catch (\Exception $exc) {
        // Log the error
        $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        
        // Return empty data structure
        $processedData = $this->getEmptyDataStructure();
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        
        return view('AI.predictive_analysis', compact('menus', 'screens', 'modules', 'processedData'))
            ->with('error', 'An error occurred: ' . $exc->getMessage());
    }
}
private function processRiskAnalysisData($data)
{
    // Initialize counters
    $totalUsers = 0;
    $processedUsers = 0;
    $riskSummary = [
        'high' => 0,
        'medium' => 0,
        'low' => 0
    ];
    
    $processedData = [];
    
    // Check if data is in the expected format (single user with courses)
    if (isset($data['mode']) && isset($data['user_id']) && isset($data['courses'])) {
        $userData = $data;
        
        // Count total users (1 in this case)
        $totalUsers = 1;
        $processedUsers = 1;
        
        // Process courses for this user
        $userCourses = [];
        foreach ($userData['courses'] as $course) {
            // Convert risk level to lowercase for consistency
            $riskLevel = strtolower($course['risk_level']);
            
            // Update risk summary
            if (isset($riskSummary[$riskLevel])) {
                $riskSummary[$riskLevel]++;
            }
            
            $userCourses[] = [
                'course_id' => $course['course_id'],
                'risk_level' => strtoupper($course['risk_level']), // Keep uppercase for display
                'probability' => $course['probability'],
                'reason' => $course['reason'],
                'prediction_type' => $course['prediction_type']
            ];
        }
        
        $processedData[] = [
            'user_id' => $userData['user_id'],
            'courses' => $userCourses,
            'total_courses' => count($userCourses)
        ];
    }
    
    // Calculate percentages for risk distribution
    $totalCourses = array_sum($riskSummary);
    $riskPercentages = [
        'high' => $totalCourses > 0 ? round(($riskSummary['high'] / $totalCourses) * 100) : 0,
        'medium' => $totalCourses > 0 ? round(($riskSummary['medium'] / $totalCourses) * 100) : 0,
        'low' => $totalCourses > 0 ? round(($riskSummary['low'] / $totalCourses) * 100) : 0
    ];
    
    return [
        'total_users' => $totalUsers,
        'processed_users' => $processedUsers,
        'total_courses' => $totalCourses,
        'risk_summary' => $riskSummary,
        'risk_percentages' => $riskPercentages,
        'data' => $processedData
    ];
}

/**
 * Return empty data structure for when API fails
 */
private function getEmptyDataStructure()
{
    return [
        'total_users' => 0,
        'processed_users' => 0,
        'total_courses' => 0,
        'risk_summary' => [
            'high' => 0,
            'medium' => 0,
            'low' => 0
        ],
        'risk_percentages' => [
            'high' => 0,
            'medium' => 0,
            'low' => 0
        ],
        'data' => []
    ];
}



   public function ai_course_show($encryptedId)
{
    $method = 'Method => AIController => ai_course_show';

    try {
        $user_id = session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
         $id = Crypt::decrypt($encryptedId);
        // Get the main course
       
        $course = DB::table('elearning_courses')
            ->where('course_id', $id)
            ->first();

        if (!$course) {
            return redirect()->back()->with('error', 'Course not found!');
        }

        // Get class IDs from the comma-separated string in elearning_courses
        $classIds = $course->course_classes ? explode(',', $course->course_classes) : [];

        // Get all classes for this course
        $classes = collect();

        if (!empty($classIds)) {
            $classes = DB::table('elearning_classes')
                ->whereIn('class_id', $classIds)
                ->orderByRaw('FIELD(class_id, ' . implode(',', $classIds) . ')') // Preserve order
                ->get()
                ->map(function($class) {
                    // Get quiz details for each class
                    if ($class->quiz_id) {
                        $class->quiz = DB::table('elearning_practice_quiz')
                            ->where('quiz_id', $class->quiz_id)
                            ->first();
                        
                        // Parse quiz questions
                        if ($class->quiz && $class->quiz->quiz_questions) {
                            $class->quiz->questions = $this->parseQuizQuestions($class->quiz->quiz_questions);
                        }
                    }
                    return $class;
                });
        }


       
        // Get final exam for this course
        $exam = DB::table('elearning_exam')
            ->join('elearning_practice_quiz', 'elearning_exam.quiz_id', '=', 'elearning_practice_quiz.quiz_id')
            ->where('elearning_exam.id', $course->exam_id)
            ->first();
        
        if ($exam) {
            $exam->questions = $this->parseQuizQuestions($exam->quiz_questions);
        }

        // Get data needed for the Publish modal (same as admincourse function)
        $rows = array();

        // Get elearning classes for dropdown
        $rows['elearning_classes'] = DB::table('elearning_classes')
            ->select('*')
            ->where('drop_class', '0')
            ->orderBy('class_id', 'desc')
            ->get();

        // Get course categories for dropdown
        $rows['course_catagory_name'] = DB::table('course_catagory')
            ->select('*')
            ->orderBy('catagory_id', 'desc')
            ->get();

        // Get designations for dropdown
        $rows['designation'] = DB::table('designation')
            ->select('*')
            ->orderBy('designation_id', 'desc')
            ->get();

        // Get users for dropdown
        $rows['users'] = DB::table('users')
            ->select('*')
            ->orderBy('id', 'desc')
            ->get();

        // Get roles for dropdown
        $roles = DB::table('uam_roles')
            ->select('*')
            ->where('active_flag', 0)
            ->get();

        // Get additional data
        $rows1 = array();
        
        // Get exam list for dropdown
        $rows1['exam_list'] = DB::table('elearning_exam')
            ->select('*')
            ->where('elearning_exam.active_flag', '0')
            ->orderBy('id', 'desc')
            ->get();

        // Get certificate templates for dropdown
        $rows1['certificate_templates'] = DB::table('certificate_templates')
            ->where('active_flag', '0')
            ->get();

        // Get quiz dropdown data
        $rows1['quiz_dropdown'] = DB::select('SELECT e.* from elearning_practice_quiz AS e 
            left join elearning_localadaptation AS l ON e.quiz_id=l.quiz_id 
            left join elearning_ethnictest AS et ON e.quiz_id=et.quiz_id 
            left join elearning_exam AS el ON e.quiz_id=el.quiz_id 
            WHERE l.quiz_id IS NULL AND e.drop_quiz=0');

        // Get quiz names
        $rows1['quiz_name'] = DB::table('elearning_practice_quiz')
            ->where('drop_quiz', '0')
            ->get();

        // Get course category data for dropdown
        $category = $this->course_list(request());
        $rows2['course_category'] = $category['rows2']['course_category'] ?? [];

        // Get course classes data
        $rows3['elearning_classes'] = DB::table('elearning_classes')
            ->select('*')
            ->where('drop_class', '0')
            ->orderBy('class_id', 'desc')
            ->get();

        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view('AI.course_show', compact(
            'menus', 
            'screens', 
            'modules', 
            'course', 
            'classes', 
            'exam', 
            'rows',
            'rows1',
            'rows2',
            'rows3',
            'roles'
        ));

    } catch (\Exception $exc) {
        return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), 
            $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
}

// Helper function to parse quiz questions
private function parseQuizQuestions($quizQuestions)
{
    $questions = [];
    $questionIds = explode(',', $quizQuestions);
    
    foreach ($questionIds as $questionId) {
        list($id, $type) = explode('-', $questionId);
        
        switch ($type) {
            case 'long':
                $question = DB::table('elearning_questions_long_answer')
                    ->where('question_id', $id)
                    ->first();
                break;
            case 'mcq':
                $question = DB::table('elearning_questions_mcq')
                    ->where('question_id', $id)
                    ->first();
                break;
            case 'short':
                $question = DB::table('elearning_questions_short_answer')
                    ->where('question_id', $id)
                    ->first();
                break;
            case 'boolean':
                $question = DB::table('elearning_questions_true_false')
                    ->where('question_id', $id)
                    ->first();
                break;
            default:
                $question = null;
        }
        
        if ($question) {
            $question->question_type = $type;
            $questions[] = $question;
        }
    }
    
    return $questions;
}
  public function course_list(Request $request)
    {


        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => tryController => course_list';
        try {
            $request =  array();
            $gatewayURL = config('setting.api_gateway_url') . '/course/course_list';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);


            $objData = json_decode($this->decryptData($response->Data));

            $code = $objData->Code;

            if ($code == "401") {

                return redirect()->route('unauthenticated')->send();
            }
            $rows2 = json_decode(json_encode($objData->Data), true);



            return $rows2;
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function course_publish(Request $request, $id)
{
    $method = 'Method => AIController => course_publish';
  
    try {
        $user_id = session()->get("userID");
        if ($user_id == null) {
            return redirect()->route('login');
        }
 
        
       

        // Get the existing course
        $course = DB::table('elearning_courses')
            ->where('course_id', $id)
            ->first();
        DB::table('ai_course_response')
                ->where('course_id', $id)
                ->update([
                    'is_published' => '1',
                 
                    
                ]);


        if (!$course) {
            return redirect()->back()->with('error', 'Course not found!');
        }

        // Handle file uploads
        $course_introduction = $course->course_introduction;
        // $course_banner = $course->course_banner;
        $course_summary = $course->course_summary;

               

        $storagepath_ursb_old1 = public_path() . '/uploads/course/' . $user_id; //system_store_pdf
            $storagepath_ursb = '/uploads/course/' . $user_id; //database_location
            if (!File::exists($storagepath_ursb_old1)) {
                File::makeDirectory($storagepath_ursb_old1); //folder_creation_when_folder_doesn't_esist
            }
            $data['banner_path'] = $storagepath_ursb;
            $documentsb =  $request->course_banner;
            $files = $documentsb->getClientOriginalName();
            $findspace = array(' ', '&', "'", '"');
            $replacewith = array('-', '-');
            $proposal_files1 = str_replace($findspace, $replacewith, $files); //proper_file_name-database field
            $documentsb->move($storagepath_ursb_old1, $proposal_files1); //storing the file in the system
            // $data['course_banner'] = $proposal_files1;
            // dd($proposal_files1);
        // Process arrays to JSON
        $user_ids = $request->has('user_ids') ? json_encode($request->user_ids) : null;
     

        // Get category name
        $category = DB::table('course_catagory')
            ->where('catagory_id', $request->course_category_id)
            ->first();

        $category_name = $category ? $category->catagory_name : '';
                 $user_ids = '';
            $userIds = $request->input('user_ids');

        if (in_array('All', $userIds)) {
            $user_ids = User::pluck('id')->toArray();
            $userIds = implode(',', $user_ids);
        } 
    // dd($request->all(),$userIds);
        // Prepare update data
        
        $updateData = [
          
           
            'designation_id' => $request->designation_id,
            'user_ids' => $userIds,
            'course_certificate' => $request->course_certificate,
            'course_exam' => $request->course_exam,
            'course_introduction' => $course_introduction,
            'course_banner' => $proposal_files1,
            'course_summary' => $course_summary,
            'course_pay' => $request->course_pay,
            'course_price' => $request->course_price ?? 0,
            'cetificate_template' => $request->certificate_template,
            'certificate_expiry' => $request->certificate_expiry,
            'course_expiry_period' => $request->course_expiry_period,
            'course_noperiod' => $request->course_noperiod,
            'course_start_period' => $request->course_start_period,
            'course_end_period' => $request->course_end_period,
           
            'exam_date' => $request->exam_date,
            'pass_percentage' => $request->pass_percentage,
            'course_instructor' => $request->course_instructor,
       
            'restricted_access' => $request->restricted_access,
             'course_cpt_points' => $request->course_cpt_points,
            'course_pin' => $request->course_pin,
            'drop_course' => '0', // Set to active
          
           
        ];

        // Remove null values
        $updateData = array_filter($updateData, function($value) {
            return !is_null($value);
        });

        // Update the course
        $updated = DB::table('elearning_courses')
            ->where('course_id', $id)
            ->update($updateData);

        if ($updated) {
            // Log the publishing activity
           
           

            return redirect()->route('ai_course_list')
                ->with('success', 'Course has been successfully published!');
        } else {
            return redirect()->back()
                ->with('error', 'Failed to publish the course. Please try again.');
        }

    } catch (\Exception $exc) {
        return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), 
            $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
}
public function getDesignationByRole(Request $request)
{
    return DB::table('designation')
        ->where('role_id', $request->role_id)
        ->select('designation_id', 'designation_name')
        ->get();
}

public function text_to_audio(Request $request)
{
    $method = 'Method=> AIController => text_to_audio';
    
    try {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        
        // Handle form submission for new audio generation
        if ($request->isMethod('post')) {
            $request->validate([
                'text' => 'required|string|max:5000',
                'language' => 'required|string|max:10',
                'speaker' => 'required|string|max:50'
            ]);
            
            // Prepare request body for API
            $data = (object) [
                'text' => $request->text,
                'language' => $request->language,
                'speaker' => $request->speaker
            ];

            $gatewayURL = config('setting.AI_service_url') . '/tools/text-to-audio/generate';

            // Make the API call
            $response = $this->AIserviceRequest($gatewayURL, 'POST', $data, $method);
            
            // Decode the response
            $response = is_string($response)
                ? json_decode($response, true)
                : $response;
                
            // Check if response is valid
            if (!$response || isset($response['error'])) {
                return redirect()->back()
                    ->with('error', 'Failed to generate audio: ' . ($response['error'] ?? 'Unknown error'))
                    ->withInput();
            }
            
            // Save to database
            DB::table('audio_conversions')->insert([
                'user_id' => $user_id,
                'text' => $request->text,
                'language' => $request->language,
                'speaker' => $request->speaker,
                'audio_url' => $response['audio_url'] ?? null,
                'file_name' => basename($response['audio_url'] ?? ''),
                'file_path' => $response['audio_url'] ?? null,
                'status' => 'completed',
                'message' => $response['message'] ?? 'Audio generated successfully',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            return redirect()->back()
                ->with('success', 'Audio generated successfully!');
        }
        
        // Get all audio files for the user
        $audioFiles = DB::table('audio_conversions')
            ->where('user_id', $user_id)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
         $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view('AI.text_to_audio', compact('audioFiles', 'menus', 'screens', 'modules'));
        
    } catch (\Exception $exc) {
        // Log the error
        $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        
        return redirect()->back()
            ->with('error', 'An error occurred: ' . $exc->getMessage());
    }
}

// Function to delete audio entry (soft delete)
public function delete_audio(Request $request, $id)
{
    try {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        
        // Soft delete by updating deleted_at
        $deleted = DB::table('audio_conversions')
            ->where('id', $id)
            ->where('user_id', $user_id)
            ->update([
                'deleted_at' => now()
            ]);
            
        if ($deleted) {
            return redirect()->route('text_to_audio')
                ->with('success', 'Audio deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Audio not found or already deleted!');
        }
            
    } catch (\Exception $exc) {
        return redirect()->back()->with('error', 'Delete failed: ' . $exc->getMessage());
    }
}

public function globalChat(Request $request)
{
    $method = 'Method=> AIController => globalChat';
    
    try {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        // Validate request
        $request->validate([
            'message' => 'required|string|max:2000'
        ]);
        
        // Prepare request body for API
        $data = (object) [
            'message' => $request->message
        ];

        $gatewayURL = config('setting.AI_service_url') . '/api/global-chat';
      
        // Make the API call
        $response = $this->AIserviceRequest($gatewayURL, 'POST', $data, $method);
        
        // Decode the response
        $response = is_string($response)
            ? json_decode($response, true)
            : $response;
            
        // Check if response is valid
        if (!$response || isset($response['error'])) {
            return response()->json([
                'error' => 'Failed to get response: ' . ($response['error'] ?? 'Unknown error')
            ], 500);
        }
        
        return response()->json([
            'success' => true,
            'response' => $response['response'] ?? '',
            'status' => $response['status'] ?? 'success'
        ]);
        
    } catch (\Exception $exc) {
        $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        
        return response()->json([
            'error' => 'An error occurred: ' . $exc->getMessage()
        ], 500);
    }
}


 

  



}