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
        if ($user_id == null) {
            return view('auth.login');
        }

        // Get the selected questions data
        $selectedQuestions = json_decode($request->selected_questions, true);
        
        // Get the full course data
        $courseData = json_decode($request->course_data, true);
        
        // Get the course ID from the stored response
        $course = DB::table('ai_course_response')
            ->where('course_name', $courseData['course_name'])
            ->orderBy('id', 'desc')
            ->first();
            
        if (!$course) {
            return redirect()->back()->with('error', 'Course not found!');
        }

        // Get all classes for this course
        $allClasses = DB::table('ai_course_response_classes')
            ->where('ai_course_response_id', $course->id)
            ->orderBy('class_order')
            ->get();

        // Filter selected classes
        $selectedClassIndices = $selectedQuestions['classes'] ?? [];
        $selectedClasses = [];
        
        foreach ($allClasses as $index => $class) {
            if (in_array($index, $selectedClassIndices)) {
                $selectedClasses[] = $class;
            }
        }

        // Start transaction
        DB::beginTransaction();

        try {
            // 1. Create the main course record
            
            $courseID = DB::table('elearning_courses')->insertGetId([
                'course_name' => $courseData['course_name'],
                'course_description' => $courseData['course_description'],
                'course_category' => '26',
                // 'course_duration' => $courseData['course_duration'],
                // 'course_quota' => 0,
                // 'course_type' => $courseData['course_type'],
                // 'points_required' => 0,
                // 'drop_course' => '0',
                // 'cover_photo' => $courseData['course_banner_url'] ?? null,
                // 'created_at' => now(),
                // 'updated_at' => now()
            ]);
           
            // 2. Create each selected class with its quiz
            foreach ($selectedClasses as $classIndex => $class) {
                $quizData = json_decode($class->quiz, true);
                $selectedQuizQuestions = $selectedQuestions['quiz'] ?? [];
                
                // Filter quiz questions for this specific class
                $classQuizQuestions = array_filter($selectedQuizQuestions, function($q) use ($classIndex) {
                    return $q['classIndex'] == $classIndex;
                });

                // Prepare quiz questions array
                $quiz_questions = [];
                $points = 0;

                // Process LONG questions for this class
                $longQuestions = $quizData['long'] ?? [];
                foreach ($longQuestions as $qIndex => $q) {
                    // Check if this question is selected
                    $isSelected = false;
                    foreach ($classQuizQuestions as $selectedQ) {
                        if ($selectedQ['type'] == 'long' && $selectedQ['questionIndex'] == $qIndex) {
                            $isSelected = true;
                            break;
                        }
                    }
                    
                    if ($isSelected) {
                        $quizLong = DB::table('elearning_questions_long_answer')->insertGetId([
                            'question_name' => substr($q['question_text'], 0, 100),
                            'question'      => $q['question_text'],
                            'keywords'      => json_encode([$q['answer']]),
                            'points'        => 10,
                            'question_type' => 'long',
                            'drop_question' => '0',
                            'created_at'    => now()
                        ]);
                        $quiz_questions[] = $quizLong . '-long';
                        $points += 10;
                    }
                }

                // Process MCQ questions for this class
                $mcqQuestions = $quizData['mcq'] ?? [];
                foreach ($mcqQuestions as $qIndex => $q) {
                    // Check if this question is selected
                    $isSelected = false;
                    foreach ($classQuizQuestions as $selectedQ) {
                        if ($selectedQ['type'] == 'mcq' && $selectedQ['questionIndex'] == $qIndex) {
                            $isSelected = true;
                            break;
                        }
                    }
                    
                    if ($isSelected) {
                        // Format options for database
                        $choices = [];
                        foreach ($q['options'] as $option) {
                            $choices[] = $option['text'];
                        }
                        
                        $quizMCQ = DB::table('elearning_questions_mcq')->insertGetId([
                            'question_name'    => substr($q['question_text'], 0, 100),
                            'question'         => $q['question_text'],
                            'choices'          => json_encode($choices),
                            'correct_choices'  => $q['correct_option_id'],
                            'points'           => 5,
                            'question_type'    => 'mcq',
                            'drop_question'    => '0',
                            'created_at'       => now()
                        ]);
                        $quiz_questions[] = $quizMCQ . '-mcq';
                        $points += 5;
                    }
                }

                // Process SHORT questions for this class
                $shortQuestions = $quizData['short'] ?? [];
                foreach ($shortQuestions as $qIndex => $q) {
                    // Check if this question is selected
                    $isSelected = false;
                    foreach ($classQuizQuestions as $selectedQ) {
                        if ($selectedQ['type'] == 'short' && $selectedQ['questionIndex'] == $qIndex) {
                            $isSelected = true;
                            break;
                        }
                    }
                    
                    if ($isSelected) {
                        $quizShort = DB::table('elearning_questions_short_answer')->insertGetId([
                            'question_name' => substr($q['question_text'], 0, 100),
                            'question'      => $q['question_text'],
                            'keywords'      => $q['answer'],
                            'points'        => 5,
                            'question_type' => 'short',
                            'drop_question' => '0',
                            'created_at'    => now()
                        ]);
                        $quiz_questions[] = $quizShort . '-short';
                        $points += 5;
                    }
                }

                // Process TRUE/FALSE questions for this class
                $tfQuestions = $quizData['true_false'] ?? [];
                foreach ($tfQuestions as $qIndex => $q) {
                    // Check if this question is selected
                    $isSelected = false;
                    foreach ($classQuizQuestions as $selectedQ) {
                        if ($selectedQ['type'] == 'true_false' && $selectedQ['questionIndex'] == $qIndex) {
                            $isSelected = true;
                            break;
                        }
                    }
                    
                    if ($isSelected) {
                        $boolean = DB::table('elearning_questions_true_false')->insertGetId([
                            'question_name' => substr($q['question_text'], 0, 100),
                            'question' => $q['question_text'],
                            'answer' => strtolower($q['answer']) === 'true' ? 'on' : 'off',
                            'points' => 5,
                            'question_type' => "boolean",
                            'drop_question' => '0',
                            'created_at' => now()
                        ]);
                        $quiz_questions[] = $boolean . '-boolean';
                        $points += 5;
                    }
                }

                // Create quiz if there are questions
                $quizID = null;
                if (!empty($quiz_questions)) {
                    $quizID = DB::table('elearning_practice_quiz')->insertGetId([
                        'quiz_name' => 'Quiz-' . str_pad($classIndex + 1, 3, '0', STR_PAD_LEFT),
                        'quiz_questions' => implode(",", $quiz_questions),
                        'points' => $points,
                        'drop_quiz' => '0',
                        'evaluation' => 1,
                        'created_at' => now()
                    ]);
                }

                // Create the class
                $classID = DB::table('elearning_classes')->insertGetId([
                    'class_name' => $class->class_name,
                    'resource_name' => $class->class_name,
                    'class_duration' => $class->target_video_duration,
                    'class_format' => 'mp4',
                    'class_description' => $class->class_description,
                    'quiz_id' => $quizID,
                    'class_quiz' => $quizID ? 'yes' : 'no',
                    // 'created_at' => now(),
                    // 'updated_at' => now()
                ]);

                // // Link class to course
                // DB::table('elearning_course_classes')->insert([
                //     'course_id' => $courseID,
                //     'class_id' => $classID,
                //     'class_order' => $classIndex + 1,
                //     'created_at' => now()
                // ]);
            }

            

            // 3. Create final exam if selected
            $finalExamData = $courseData['final_exam'] ?? [];
            $selectedExamQuestions = $selectedQuestions['exam'] ?? [];
            
            if (!empty($selectedExamQuestions) && !empty($finalExamData)) {
                $final_quiz_questions = [];
                $final_points = 0;

                // Process final exam LONG questions
                $longQuestions = $finalExamData['long'] ?? [];
                foreach ($longQuestions as $qIndex => $q) {
                    // Check if selected
                    $isSelected = false;
                    foreach ($selectedExamQuestions as $selectedQ) {
                        if ($selectedQ['type'] == 'long' && $selectedQ['questionIndex'] == $qIndex) {
                            $isSelected = true;
                            break;
                        }
                    }
                    
                    if ($isSelected) {
                        $quizLong = DB::table('elearning_questions_long_answer')->insertGetId([
                            'question_name' => substr($q['question_text'], 0, 100),
                            'question'      => $q['question_text'],
                            'keywords'      => json_encode([$q['answer']]),
                            'points'        => 15,
                            'question_type' => 'long',
                            'drop_question' => '0',
                            'created_at'    => now()
                        ]);
                        $final_quiz_questions[] = $quizLong . '-long';
                        $final_points += 15;
                    }
                }

                // Process final exam MCQ questions
                $mcqQuestions = $finalExamData['mcq'] ?? [];
                foreach ($mcqQuestions as $qIndex => $q) {
                    // Check if selected
                    $isSelected = false;
                    foreach ($selectedExamQuestions as $selectedQ) {
                        if ($selectedQ['type'] == 'mcq' && $selectedQ['questionIndex'] == $qIndex) {
                            $isSelected = true;
                            break;
                        }
                    }
                    
                    if ($isSelected) {
                        $choices = [];
                        foreach ($q['options'] as $option) {
                            $choices[] = $option['text'];
                        }
                        
                        $quizMCQ = DB::table('elearning_questions_mcq')->insertGetId([
                            'question_name'    => substr($q['question_text'], 0, 100),
                            'question'         => $q['question_text'],
                            'choices'          => json_encode($choices),
                            'correct_choices'  => $q['correct_option_id'],
                            'points'           => 10,
                            'question_type'    => 'mcq',
                            'drop_question'    => '0',
                            'created_at'       => now()
                        ]);
                        $final_quiz_questions[] = $quizMCQ . '-mcq';
                        $final_points += 10;
                    }
                }

                // Process final exam SHORT questions
                $shortQuestions = $finalExamData['short'] ?? [];
                foreach ($shortQuestions as $qIndex => $q) {
                    // Check if selected
                    $isSelected = false;
                    foreach ($selectedExamQuestions as $selectedQ) {
                        if ($selectedQ['type'] == 'short' && $selectedQ['questionIndex'] == $qIndex) {
                            $isSelected = true;
                            break;
                        }
                    }
                    
                    if ($isSelected) {
                        $quizShort = DB::table('elearning_questions_short_answer')->insertGetId([
                            'question_name' => substr($q['question_text'], 0, 100),
                            'question'      => $q['question_text'],
                            'keywords'      => $q['answer'],
                            'points'        => 10,
                            'question_type' => 'short',
                            'drop_question' => '0',
                            'created_at'    => now()
                        ]);
                        $final_quiz_questions[] = $quizShort . '-short';
                        $final_points += 10;
                    }
                }

                // Process final exam TRUE/FALSE questions
                $tfQuestions = $finalExamData['true_false'] ?? [];
                foreach ($tfQuestions as $qIndex => $q) {
                    // Check if selected
                    $isSelected = false;
                    foreach ($selectedExamQuestions as $selectedQ) {
                        if ($selectedQ['type'] == 'true_false' && $selectedQ['questionIndex'] == $qIndex) {
                            $isSelected = true;
                            break;
                        }
                    }
                    
                    if ($isSelected) {
                        $boolean = DB::table('elearning_questions_true_false')->insertGetId([
                            'question_name' => substr($q['question_text'], 0, 100),
                            'question' => $q['question_text'],
                            'answer' => strtolower($q['answer']) === 'true' ? 'on' : 'off',
                            'points' => 5,
                            'question_type' => "boolean",
                            'drop_question' => '0',
                            'created_at' => now()
                        ]);
                        $final_quiz_questions[] = $boolean . '-boolean';
                        $final_points += 5;
                    }
                }

                // Create final exam quiz
                if (!empty($final_quiz_questions)) {
                    $finalQuizID = DB::table('elearning_practice_quiz')->insertGetId([
                        'quiz_name' => 'Final-Exam',
                        'quiz_questions' => implode(",", $final_quiz_questions),
                        'points' => $final_points,
                        'drop_quiz' => '0',
                        'evaluation' => 1,
                        'created_at' => now()
                    ]);

                    // Link final exam to course
                    DB::table('elearning_exam')->insert([
                        'user_category' => '20',
                        'quiz_id' => $finalQuizID,
                        'exam_name' =>$courseData['course_name'],
                        'created_at' => now()
                    ]);
                }
            }

         

            DB::commit();

            // Redirect with success message
            return redirect()->route('ai_course_list')
                ->with('success', 'Course created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

    } catch (\Exception $exc) {
        return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
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
   public function ai_course_show($id)
{
    $method = 'Method => AIController => ai_course_show';

    try {
        $user_id = session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }

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
            ->where('elearning_exam.quiz_id', '29')
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

        if (!$course) {
            return redirect()->back()->with('error', 'Course not found!');
        }

        // Handle file uploads
        $course_introduction = $course->course_introduction;
        $course_banner = $course->course_banner;
        $course_summary = $course->course_summary;

        if ($request->hasFile('course_introduction')) {
            $file = $request->file('course_introduction');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/courses/introduction'), $filename);
            $course_introduction = 'uploads/courses/introduction/' . $filename;
        }

        if ($request->hasFile('course_banner')) {
            $file = $request->file('course_banner');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/courses/banner'), $filename);
            $course_banner = 'uploads/courses/banner/' . $filename;
        }

        if ($request->hasFile('course_summary')) {
            $file = $request->file('course_summary');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/courses/summary'), $filename);
            $course_summary = 'uploads/courses/summary/' . $filename;
        }

        // Process arrays to JSON
        $user_ids = $request->has('user_ids') ? json_encode($request->user_ids) : null;
     

        // Get category name
        $category = DB::table('course_catagory')
            ->where('catagory_id', $request->course_category_id)
            ->first();

        $category_name = $category ? $category->catagory_name : '';

        // Prepare update data
        $updateData = [
          
           
            'designation_id' => $request->designation_id,
            'user_ids' => $user_ids,
            'course_certificate' => $request->course_certificate,
            'course_exam' => $request->course_exam,
            'course_introduction' => $course_introduction,
            'course_banner' => $course_banner,
            'course_summary' => $course_summary,
            'course_pay' => $request->course_pay,
            'course_price' => $request->course_price ?? 0,
            'cetificate_template' => $request->cetificate_template,
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
           
           

            return redirect()->route('ai_course.show', $id)
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


}