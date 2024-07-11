<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\course;
use App\Models\courseCart;
use phpDocumentor\Reflection\Types\Null_;
use Illuminate\Support\Facades\Auth;

class elearningController extends BaseController
{
    // public function WriteFileLog($request)
    // {
    //     try {
    //         Log::error($request);
    //     } catch (\Exception $exc) {
    //         Log::error('Method => BaseController => WriteFileLog => Write log file error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
    //     }
    // }
    public function serviceRequest($gatewayURL, $action, $body, $method)
    {
        try {
            //Credentials
            $client_id  = "admin";
            $client_pass = "Login@4107";
            //HTTP options
            $opts = array(
                'http' =>
                array(
                    'method'    => $action,
                    'header'    => array('Content-type: application/json', 'Authorization: Basic ' . base64_encode("$client_id:$client_pass")),
                    'content' => "some_content"
                )
            );
            //Do request
            $context = stream_context_create($opts);
            $json = file_get_contents($gatewayURL, false, $context);
            return $json;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = 'Method => BaseController => serviceRequest';
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            return 'Failure';
        }
    }

    function apiCourses()
    {
        $logMethod = 'Method => ClaimInvoiceDisposalController => index';
        $gatewayURL = 'http://localhost:10/elearning6/web/api/courses';
        $response =  $this->serviceRequest($gatewayURL, 'GET', '', $logMethod);
        $courses = json_decode($response);
        return $courses;
    }

    function apiClasses()
    {
        $logMethod = 'Method => ClaimInvoiceDisposalController => index';
        $gatewayURL = 'http://localhost:10/elearning6/web/api/classes';
        $response =  $this->serviceRequest($gatewayURL, 'GET', '', $logMethod);
        $classes = json_decode($response);
        return $classes;
    }

    function apiQuestionsTrueFalse()
    {
        $logMethod = 'Method => ClaimInvoiceDisposalController => index';
        $gatewayURL = 'http://localhost:10/elearning6/web/api/questions/boolean';
        $response =  $this->serviceRequest($gatewayURL, 'GET', '', $logMethod);
        $booleanQuestions = json_decode($response);
        return $booleanQuestions;
    }

    function apiQuestionsMultipleChoice()
    {
        $logMethod = 'Method => ClaimInvoiceDisposalController => index';
        $gatewayURL = 'http://localhost:10/elearning6/web/api/questions/mcq';
        $response =  $this->serviceRequest($gatewayURL, 'GET', '', $logMethod);
        $mcqQuestions = json_decode($response);
        return $mcqQuestions;
    }

    function apiQuestionsShortAnswer()
    {
        $logMethod = 'Method => ClaimInvoiceDisposalController => index';
        $gatewayURL = 'http://localhost:10/elearning6/web/api/questions/short';
        $response =  $this->serviceRequest($gatewayURL, 'GET', '', $logMethod);
        $shortAnswerQuestions = json_decode($response);
        return $shortAnswerQuestions;
    }

    function apiQuestionsLongAnswer()
    {
        $logMethod = 'Method => ClaimInvoiceDisposalController => index';
        $gatewayURL = 'http://localhost:10/elearning6/web/api/questions/long';
        $response =  $this->serviceRequest($gatewayURL, 'GET', '', $logMethod);
        $longAnswerQuestions = json_decode($response);
        return $longAnswerQuestions;
    }

    function apiPracticeQuiz()
    {
        $logMethod = 'Method => ClaimInvoiceDisposalController => index';
        $gatewayURL = 'http://localhost:10/elearning6/web/api/practice/quiz';
        $response =  $this->serviceRequest($gatewayURL, 'GET', '', $logMethod);
        $practiceQuiz = json_decode($response);
        return $practiceQuiz;
    }

    function apiAssessment()
    {
        $logMethod = 'Method => ClaimInvoiceDisposalController => index';
        $gatewayURL = 'http://localhost:10/elearning6/web/api/assessment';
        $response =  $this->serviceRequest($gatewayURL, 'GET', '', $logMethod);
        $assessment = json_decode($response);
        return $assessment;
    }

    function courseImport()
    {
        $courseNewIds = [];
        $courseOldIds = [];
        $courses = $this->apiCourses();
        echo "<br>Fetched Courses";
        foreach ($courses as $course) {
            $courseId = $course->courseId;
            $courseBanner = $course->courseBanner;
            $courseName = $course->courseName;
            $courseInstructor = $course->courseInstructor;
            $coursePeriod = $course->coursePeriod;
            if ($coursePeriod != "") {
                $period = explode("  ,  ", $coursePeriod);
                $courseStartPeriod = $period[0];
                $courseEndPeriod = $period[1];
            } else {
                $courseStartPeriod = null;
                $courseEndPeriod = null;
            }
            $coursePay = $course->coursePay;
            $coursePrice = $course->coursePrice;
            $courseDescription = $course->courseDescription;
            $courseIntroduction = "/elearning6/web/sites/default/files/" . $course->courseIntroduction;
            $courseTags = $course->courseTags;
            $courseSkillsRequired = $course->courseSkillsRequired;
            $courseGainSkills = $course->courseGainSkills;
            $courseClasses = $course->courseClasses;
            $courseBonus = $course->courseBonus;
            $isOldCourse = DB::select("select * from elearning_courses where course_id=$courseId");
            if (empty($isOldCourse)) {
                // Course import
                echo "<br>Course" . "$courseId" . "Import started";
                DB::table('elearning_courses')
                    ->insert([
                        'course_id' => "$courseId",
                        'course_banner' => "$courseBanner",
                        'course_name' => "$courseName",
                        'course_instructor' => "$courseInstructor",
                        'course_start_period' => "$courseStartPeriod",
                        'course_end_period' => "$courseEndPeriod",
                        'course_pay' => "$coursePay",
                        'course_price' => "$coursePrice",
                        'course_description' => "$courseDescription",
                        'course_introduction' => "$courseIntroduction",
                        'course_tags' => "$courseTags",
                        'course_skills_required' => "$courseSkillsRequired",
                        'course_gain_skills' => "$courseGainSkills",
                        'course_classes' => "$courseClasses",
                        // 'course_bonus' => "$courseBonus",
                    ]);
                echo "<br>Course" . "$courseId" . "Import done";
            } else {
                // Course update
                echo "<br>Course" . "$courseId" . "update started";
                DB::table('elearning_courses')
                    ->where('course_id', $courseId)
                    ->update([
                        'course_id' => "$courseId",
                        'course_banner' => "$courseBanner",
                        'course_name' => "$courseName",
                        'course_instructor' => "$courseInstructor",
                        'course_start_period' => "$courseStartPeriod",
                        'course_end_period' => "$courseEndPeriod",
                        'course_pay' => "$coursePay",
                        'course_price' => "$coursePrice",
                        'course_description' => "$courseDescription",
                        'course_introduction' => "$courseIntroduction",
                        'course_tags' => "$courseTags",
                        'course_skills_required' => "$courseSkillsRequired",
                        'course_gain_skills' => "$courseGainSkills",
                        'course_classes' => "$courseClasses",
                        // 'course_bonus' => "$courseBonus",
                    ]);
                echo "<br>Course" . "$courseId" . "update done";
            }
        }
        // Courses destroy
        foreach ($courses as $course) {
            array_splice($courseNewIds, 1, 0, $course->courseId);
        }
        $availableCourses = DB::select("select course_id from elearning_courses where drop_course=0");
        foreach ($availableCourses as $availableCourse) {
            array_splice($courseOldIds, 1, 0, $availableCourse->course_id);
        }
        $deletedCourseIds = array_diff($courseOldIds, $courseNewIds);
        echo "<br>Fetched Deleted Courses";
        foreach ($deletedCourseIds as $deletedCourseId) {
            DB::table('elearning_courses')
                ->where('course_id', $deletedCourseId)
                ->update([
                    'drop_course' => 1
                ]);
            echo "<br>Course" . "$deletedCourseId" . "marked deleted";
        }
        return;
    }

    function classImport()
    {
        $classNewIds = [];
        $classOldIds = [];
        $classes = $this->apiClasses();
        echo "<br>Fetched Classes";
        foreach ($classes as $class) {
            $classId = $class->classId;
            $className = $class->className;
            $classIn = $class->classIn;
            // $classOrder = $class->classOrder;
            $resourceName = "/elearning6/web/sites/default/files/" . $class->resourceName;
            $classDuration = $class->classDuration;
            $isOldClass = DB::select("select * from elearning_classes where class_id=$classId");
            if (empty($isOldClass)) {
                // Classes import
                echo "<br>Class" . "$classId" . "Import started";
                DB::table('elearning_classes')
                    ->insert([
                        'class_id' => "$classId",
                        'class_name' => "$className",
                        'class_in' => "$classIn",
                        // 'class_order' => "$classOrder",
                        'resource_name' => "$resourceName",
                        'class_duration' => "$classDuration",
                    ]);
                echo "<br>Class" . "$classId" . "Import done";
            } else {
                // Classes update
                echo "<br>Class" . "$classId" . "Update started";
                DB::table('elearning_classes')
                    ->where('class_id', $classId)
                    ->update([
                        'class_id' => "$classId",
                        'class_name' => "$className",
                        'class_in' => "$classIn",
                        // 'class_order' => "$classOrder",
                        'resource_name' => "$resourceName",
                        'class_duration' => "$classDuration",
                    ]);
                echo "<br>Class" . "$classId" . "Update done";
            }
        }
        // classes destroy
        foreach ($classes as $class) {
            array_splice($classNewIds, 1, 0, $class->classId);
        }
        $availableClasses = DB::select("select class_id from elearning_classes where drop_class=0");
        foreach ($availableClasses as $availableClass) {
            array_splice($classOldIds, 1, 0, $availableClass->class_id);
        }
        $deletedClassIds = array_diff($classOldIds, $classNewIds);
        echo "<br>Fetched Deleted Classes";
        foreach ($deletedClassIds as $deletedClassId) {
            DB::table('elearning_classes')
                ->where('class_id', $deletedClassId)
                ->update([
                    'drop_class' => 1
                ]);
            echo "<br>Class" . "$deletedClassId" . "marked deleted";
        }
        return;
    }

    function booleanQuestions()
    {
        $booleanNewIds = [];
        $booleanOldIds = [];
        $booleanQuestions = $this->apiQuestionsTrueFalse();
        echo "<br>Fetched Questions";
        foreach ($booleanQuestions as $booleanQuestion) {
            $questionId = $booleanQuestion->questionId;
            $questionName = $booleanQuestion->questionName;
            $question = $booleanQuestion->question;
            $answer = $booleanQuestion->answer;
            $points = $booleanQuestion->points;

            $isOldBoolean = DB::select("select * from elearning_questions_true_false where question_id=$questionId");
            if ($isOldBoolean == []) {
                // Question import
                echo "<br>Question" . "$questionId" . "Import started";
                DB::table('elearning_questions_true_false')
                    ->insert([
                        'question_id' => "$questionId",
                        'question_name' => "$questionName",
                        'question' => "$question",
                        'answer' => "$answer",
                        'points' => "$points",
                    ]);
                echo "<br>Question" . "$questionId" . "Import done";
            } else {
                // Question update
                echo "<br>Question" . "$questionId" . "Update started";
                DB::table('elearning_questions_true_false')
                    ->where('question_id', $questionId)
                    ->update([
                        'question_id' => "$questionId",
                        'question_name' => "$questionName",
                        'question' => "$question",
                        'answer' => "$answer",
                        'points' => "$points",
                    ]);
                echo "<br>Question" . "$questionId" . "Update done";
            }
            return;
        }
        // Question destroy
        foreach ($booleanQuestions as $booleanQuestion) {
            array_splice($booleanNewIds, 1, 0, $booleanQuestion->questionId);
        }
        $availableQuestions = DB::select("select question_id from elearning_questions_true_false where drop_question=0");
        foreach ($availableQuestions as $availableQuestion) {
            array_splice($booleanOldIds, 1, 0, $availableQuestion->question_id);
        }
        $deletedQuestionIds = array_diff($booleanOldIds, $booleanNewIds);
        echo "<br>Fetched Deleted Questions";
        foreach ($deletedQuestionIds as $deletedQuestionId) {
            DB::table('elearning_questions_true_false')
                ->where('question_id', $deletedQuestionId)
                ->update([
                    'drop_question' => 1
                ]);
            echo "<br>Question" . "$deletedQuestionId" . "marked deleted";
        }
    }

    function mcqQuestions()
    {
        $mcqNewIds = [];
        $mcqOldIds = [];
        $mcqQuestions = $this->apiQuestionsMultipleChoice();
        echo "<br>Fetched Questions";
        foreach ($mcqQuestions as $mcqQuestion) {
            $questionId = $mcqQuestion->questionId;
            $questionName = $mcqQuestion->questionName;
            $question = $mcqQuestion->question;
            $choices = $mcqQuestion->choices;
            $correctChoices = $mcqQuestion->correctChoices;
            $points = $mcqQuestion->points;

            $isOldMCQ = DB::select("select * from elearning_questions_mcq where question_id=$questionId");
            if ($isOldMCQ == []) {
                // Question import
                echo "<br>Question" . "$questionId" . "Import started";
                DB::table('elearning_questions_mcq')
                    ->insert([
                        'question_id' => "$questionId",
                        'question_name' => "$questionName",
                        'question' => "$question",
                        'choices' => "$choices",
                        'correct_choices' => "$correctChoices",
                        'points' => "$points",
                    ]);
                echo "<br>Question" . "$questionId" . "Import done";
            } else {
                // Question update
                echo "<br>Question" . "$questionId" . "Update started";
                DB::table('elearning_questions_mcq')
                    ->where('question_id', $questionId)
                    ->update([
                        'question_id' => "$questionId",
                        'question_name' => "$questionName",
                        'question' => "$question",
                        'choices' => "$choices",
                        'correct_choices' => "$correctChoices",
                        'points' => "$points",
                    ]);
                echo "<br>Question" . "$questionId" . "Update done";
            }
        }
        // Question destroy
        foreach ($mcqQuestions as $mcqQuestion) {
            array_splice($mcqNewIds, 1, 0, $mcqQuestion->questionId);
        }
        $availableQuestions = DB::select("select question_id from elearning_questions_mcq where drop_question=0");
        foreach ($availableQuestions as $availableQuestion) {
            array_splice($mcqOldIds, 1, 0, $availableQuestion->question_id);
        }
        $deletedQuestionIds = array_diff($mcqOldIds, $mcqNewIds);
        echo "<br>Fetched Deleted Questions";
        foreach ($deletedQuestionIds as $deletedQuestionId) {
            DB::table('elearning_questions_mcq')
                ->where('question_id', $deletedQuestionId)
                ->update([
                    'drop_question' => 1
                ]);
            echo "<br>Question" . "$deletedQuestionId" . "marked deleted";
        }
        return;
    }

    function shortAnswerQuestions()
    {
        $shortAnswerNewIds = [];
        $shortAnswerOldIds = [];
        $shortAnswerQuestions = $this->apiQuestionsShortAnswer();
        echo "<br>Fetched Questions";
        foreach ($shortAnswerQuestions as $shortAnswerQuestion) {
            $questionId = $shortAnswerQuestion->questionId;
            $questionName = $shortAnswerQuestion->questionName;
            $question = $shortAnswerQuestion->question;
            $keywords = $shortAnswerQuestion->keywords;
            $points = $shortAnswerQuestion->points;

            $isOldShortAnswer = DB::select("select * from elearning_questions_short_answer where question_id=$questionId");
            if ($isOldShortAnswer == []) {
                // Question import
                echo "<br>Question" . "$questionId" . "Import started";
                DB::table('elearning_questions_short_answer')
                    ->insert([
                        'question_id' => "$questionId",
                        'question_name' => "$questionName",
                        'question' => "$question",
                        'keywords' => "$keywords",
                        'points' => "$points",
                    ]);
                echo "<br>Question" . "$questionId" . "Import done";
            } else {
                // Question update
                echo "<br>Question" . "$questionId" . "Update started";
                DB::table('elearning_questions_short_answer')
                    ->where('question_id', $questionId)
                    ->update([
                        'question_id' => "$questionId",
                        'question_name' => "$questionName",
                        'question' => "$question",
                        'keywords' => "$keywords",
                        'points' => "$points",
                    ]);
                echo "<br>Question" . "$questionId" . "Update done";
            }
        }
        // Question destroy
        foreach ($shortAnswerQuestions as $shortAnswerQuestion) {
            array_splice($shortAnswerNewIds, 1, 0, $shortAnswerQuestion->questionId);
        }
        $availableQuestions = DB::select("select question_id from elearning_questions_short_answer where drop_question=0");
        foreach ($availableQuestions as $availableQuestion) {
            array_splice($shortAnswerOldIds, 1, 0, $availableQuestion->question_id);
        }
        $deletedQuestionIds = array_diff($shortAnswerOldIds, $shortAnswerNewIds);
        echo "<br>Fetched Deleted Questions";
        foreach ($deletedQuestionIds as $deletedQuestionId) {
            DB::table('elearning_questions_short_answer')
                ->where('question_id', $deletedQuestionId)
                ->update([
                    'drop_question' => 1
                ]);
            echo "<br>Question" . "$deletedQuestionId" . "marked deleted";
        }
        return;
    }

    function LongAnswerQuestions()
    {
        $longAnswerNewIds = [];
        $longAnswerOldIds = [];
        $longAnswerQuestions = $this->apiQuestionsLongAnswer();
        echo "<br>Fetched Questions";
        foreach ($longAnswerQuestions as $longAnswerQuestion) {
            $questionId = $longAnswerQuestion->questionId;
            $questionName = $longAnswerQuestion->questionName;
            $question = $longAnswerQuestion->question;
            $keywords = $longAnswerQuestion->keywords;
            $points = $longAnswerQuestion->points;

            $isOldLongAnswer = DB::select("select * from elearning_questions_long_answer where question_id=$questionId");
            if ($isOldLongAnswer == []) {
                // Question import
                echo "<br>Question" . "$questionId" . "Import started";
                DB::table('elearning_questions_long_answer')
                    ->insert([
                        'question_id' => "$questionId",
                        'question_name' => "$questionName",
                        'question' => "$question",
                        'keywords' => "$keywords",
                        'points' => "$points",
                    ]);
                echo "<br>Question" . "$questionId" . "Import done";
            } else {
                // Question update
                echo "<br>Question" . "$questionId" . "Update started";
                DB::table('elearning_questions_long_answer')
                    ->where('question_id', $questionId)
                    ->update([
                        'question_id' => "$questionId",
                        'question_name' => "$questionName",
                        'question' => "$question",
                        'keywords' => "$keywords",
                        'points' => "$points",
                    ]);
                echo "<br>Question" . "$questionId" . "Update done";
            }
        }
        // Question destroy
        foreach ($longAnswerQuestions as $longAnswerQuestion) {
            array_splice($longAnswerNewIds, 1, 0, $longAnswerQuestion->questionId);
        }
        $availableQuestions = DB::select("select question_id from elearning_questions_long_answer where drop_question=0");
        foreach ($availableQuestions as $availableQuestion) {
            array_splice($longAnswerOldIds, 1, 0, $availableQuestion->question_id);
        }
        $deletedQuestionIds = array_diff($longAnswerOldIds, $longAnswerNewIds);
        echo "<br>Fetched Deleted Questions";
        foreach ($deletedQuestionIds as $deletedQuestionId) {
            DB::table('elearning_questions_long_answer')
                ->where('question_id', $deletedQuestionId)
                ->update([
                    'drop_question' => 1
                ]);
            echo "<br>Question" . "$deletedQuestionId" . "marked deleted";
        }
        return;
    }

    function practiceQuiz()
    {
        $practiceQuizNewIds = [];
        $practiceQuizOldIds = [];
        $practiceQuizzes = $this->apiPracticeQuiz();
        echo "<br>Fetched practiceQuizzes";
        foreach ($practiceQuizzes as $practiceQuiz) {
            $quizId = $practiceQuiz->quizId;
            $quizName = $practiceQuiz->quizName;
            $quizQuestions = $practiceQuiz->quizQuestions;
            // dd($quizQuestions);
            $questions = explode(", ", $quizQuestions);
            $questionList = [];
            foreach ($questions as $question) {
                $boolean = DB::select("select question_id from elearning_questions_true_false where question_id=$question");
                $isBoolean = $boolean == [] ? false : true;
                $mcq = DB::select("select question_id from elearning_questions_mcq where question_id=$question");
                $isMCQ = $mcq == [] ? false : true;
                $shortAnswer = DB::select("select question_id from elearning_questions_short_answer where question_id=$question");
                $isShortAnswer = $shortAnswer == [] ? false : true;
                $longAnswer = DB::select("select question_id from elearning_questions_long_answer where question_id=$question");
                $isLongAnswer = $longAnswer == [] ? false : true;
                switch ("true") {
                    case $isBoolean:
                        $questionType = "boolean";
                        break;
                    case $isMCQ:
                        $questionType = "mcq";
                        break;
                    case $isShortAnswer:
                        $questionType = "short";
                        break;
                    case $isLongAnswer:
                        $questionType = "long";
                        break;
                }
                array_splice($questionList, 1, 0, $question . "-" . $questionType);
            }
            $questionListstr = implode(", ", $questionList);
            $isOldpracticeQuiz = DB::select("select * from elearning_practice_quiz where quiz_id=$quizId");
            if ($isOldpracticeQuiz == []) {
                // practiceQuiz import
                echo "<br>Quiz" . "$quizId" . "Import started";
                DB::table('elearning_practice_quiz')
                    ->insert([
                        'quiz_id' => "$quizId",
                        'quiz_name' => "$quizName",
                        'quiz_questions' => "$questionListstr",
                    ]);
                echo "<br>Quiz" . "$quizId" . "Import done";
            } else {
                // practiceQuiz update
                echo "<br>Quiz" . "$quizId" . "Update started";
                DB::table('elearning_practice_quiz')
                    ->where('quiz_id', $quizId)
                    ->update([
                        'quiz_id' => "$quizId",
                        'quiz_name' => "$quizName",
                        'quiz_questions' => "$questionListstr",
                    ]);
                echo "<br>Quiz" . "$quizId" . "Update done";
            }
        }
        // practiceQuiz destroy
        foreach ($practiceQuizzes as $practiceQuiz) {
            array_splice($practiceQuizNewIds, 1, 0, $practiceQuiz->quizId);
        }
        $availableQuizzes = DB::select("select quiz_id from elearning_practice_quiz where drop_quiz=0");
        foreach ($availableQuizzes as $availableQuiz) {
            array_splice($practiceQuizOldIds, 1, 0, $availableQuiz->quiz_id);
        }
        $deletedQuizIds = array_diff($practiceQuizOldIds, $practiceQuizNewIds);
        echo "<br>Fetched Deleted practiceQuizzes";
        foreach ($deletedQuizIds as $deletedQuizId) {
            DB::table('elearning_practice_quiz')
                ->where('quiz_id', $deletedQuizId)
                ->update([
                    'drop_quiz' => 1
                ]);
            echo "<br>practiceQuiz" . "$deletedQuizId" . "marked deleted";
        }
        return;
    }

    function assessment()
    {
        $assessmentNewIds = [];
        $assessmentOldIds = [];
        $assessments = $this->apiAssessment();
        echo "<br>Fetched assessments";
        foreach ($assessments as $assessment) {
            $assessmentId = $assessment->assessmentId;
            $assessmentName = $assessment->assessmentName;
            $assessmentQuestions = $assessment->assessmentQuestions;
            $questions = explode(", ", $assessmentQuestions);
            $questionList = [];
            foreach ($questions as $question) {
                $boolean = DB::select("select question_id from elearning_questions_true_false where question_id=$question");
                $isBoolean = $boolean == [] ? false : true;
                $mcq = DB::select("select question_id from elearning_questions_mcq where question_id=$question");
                $isMCQ = $mcq == [] ? false : true;
                $shortAnswer = DB::select("select question_id from elearning_questions_short_answer where question_id=$question");
                $isShortAnswer = $shortAnswer == [] ? false : true;
                $longAnswer = DB::select("select question_id from elearning_questions_long_answer where question_id=$question");
                $isLongAnswer = $longAnswer == [] ? false : true;
                switch ("true") {
                    case $isBoolean:
                        $questionType = "boolean";
                        break;
                    case $isMCQ:
                        $questionType = "mcq";
                        break;
                    case $isShortAnswer:
                        $questionType = "short";
                        break;
                    case $isLongAnswer:
                        $questionType = "long";
                        break;
                }
                array_splice($questionList, 1, 0, $question . "-" . $questionType);
            }
            $questionListstr = implode(", ", $questionList);
            $isOldassessment = DB::select("select * from elearning_assessment where assessment_id=$assessmentId");
            if ($isOldassessment == []) {
                // assessment import
                echo "<br>assessment" . "$assessmentId" . "Import started";
                DB::table('elearning_assessment')
                    ->insert([
                        'assessment_id' => "$assessmentId",
                        'assessment_name' => "$assessmentName",
                        'assessment_questions' => "$questionListstr",
                    ]);
                echo "<br>assessment" . "$assessmentId" . "Import done";
            } else {
                // assessment update
                echo "<br>assessment" . "$assessmentId" . "Update started";
                DB::table('elearning_assessment')
                    ->where('assessment_id', $assessmentId)
                    ->update([
                        'assessment_id' => "$assessmentId",
                        'assessment_name' => "$assessmentName",
                        'assessment_questions' => "$questionListstr",
                    ]);
                echo "<br>assessment" . "$assessmentId" . "Update done";
            }
        }
        // assessment destroy
        foreach ($assessments as $assessment) {
            array_splice($assessmentNewIds, 1, 0, $assessment->assessmentId);
        }
        $availableAssessments = DB::select("select assessment_id from elearning_assessment where drop_assessment=0");
        foreach ($availableAssessments as $availableAssessment) {
            array_splice($assessmentOldIds, 1, 0, $availableAssessment->assessment_id);
        }
        $deletedAssessmentIds = array_diff($assessmentOldIds, $assessmentNewIds);
        echo "<br>Fetched Deleted Assessments";
        foreach ($deletedAssessmentIds as $deletedAssessmentId) {
            DB::table('elearning_assessment')
                ->where('assessment_id', $deletedAssessmentId)
                ->update([
                    'drop_assessment' => 1
                ]);
            echo "<br>Assessment" . "$deletedAssessmentId" . "marked deleted";
        }
        // dd('assessments done');
        return;
    }

    public function elearningsync(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return redirect(url('/'));
        }
        // need to add authentication only for admin user
        // Courses
        // dd('hbhinjnjnjkbkb');
        // $style =
        //     '<style>
        //         body{
        //             background-color: #000;
        //             color: #56DB3A;
        //             font-weight: bold;
        //         }
        //     </style>';
        // echo "$style";$courseNewIds = [];

        $this->courseImport();
        $this->classImport();
        $this->booleanQuestions();
        $this->mcqQuestions();
        $this->shortAnswerQuestions();
        $this->LongAnswerQuestions();
        $this->practiceQuiz();
        $this->assessment();

        header("Location: http://localhost:10/elearning6/web");
        exit;
    }

    public function dashboard(Request $request)
    {
        {

            try {
                $user_id = $request->session()->get("userID");
                if ($user_id == null) {
                    return view('auth.login');
                }
                $method = 'Method => elearningController => dashboard';
                $data =  array();
                $data['mlhud_id'] = $user_id;
                $request =  array();

                $request['requestData'] = $data;
                //dd($request);
                $gatewayURL = config('setting.api_gateway_url') . '/elearningDashboard';
                $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
                $response = json_decode($response);
                
               

                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $rows = $parant_data['rows'];

                        // $one_row =  $parant_data['one_rows'];

                        return view('elearning.dashboard', compact('rows'));
                    }
                } else {
                    $objData = json_decode($this->decryptData($response->Data));
                    echo json_encode($objData->Code);
                    exit;
                }
            } catch (\Exception $exc) {
                //dd("bhj");
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
            }
        }
    }


    public function allCourses(Request $request)
    {
        // Authentication
        $method = 'Method => elearningEthnicTestController => allCourses';


        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return redirect(url('/'));
        }

        // Sort and Filter Checking and Assignment
        if (!isset($_GET['sorted']) || !isset($_GET['tag']) || !isset($_GET['progress']) || !isset($_GET['q'])) {
            return view('elearning.dashboard');
        } else {
            $sort = $_GET['sorted'];
            $tagFilter = $_GET['tag'];
            $progressFilter = $_GET['progress'];
            $search = $_GET['q'];
        }
        $searched = false;
        $sorted = "Recently Added";
        // Getting Non-Destroyed Courses
        $Courses = DB::select("SELECT * FROM elearning_courses WHERE drop_course=0");

        // Getting Currently Available Courses
        $availableCourseIds = [];
        $time = time();
        $currentTime = date("Y-m-d H:i:s", $time);
        foreach ($Courses as $course) {
            if ($course->course_start_period == "" || $course->course_end_period == "") {
                array_splice($availableCourseIds, 1, 0, $course->course_id);
            } else {
                $courseStartPeriod = date("Y-m-d H:i:s", strtotime($course->course_start_period));
                $courseEndPeriod = date("Y-m-d H:i:s", strtotime($course->course_end_period));
                if ($currentTime >= $courseStartPeriod && $currentTime <= $courseEndPeriod) {
                    array_splice($availableCourseIds, 1, 0, $course->course_id);
                }
            }
        }

        // Getting Currently Available Tags
        $tags1 = [];
        // getting tag column values into an array;
        foreach ($Courses as $course) {
            array_splice($tags1, 1, 0, $course->course_tags);
        }
        // converting array to string to avoid two tags in single array index
        $tags2 = implode(", ", $tags1);
        // converting back to array with single values and without duplications
        $tags3 = array_unique(explode(", ", $tags2));
        // sorting array indices properly
        $availableTags = array_values($tags3);
        // dd($search);
        // Search
        if ($search == "false") {
            $availableCourses = course::whereIn('course_id', $availableCourseIds)->paginate(8);
            $searched = false;
        } else {
            $availableCourses = course::whereIn('course_id', $availableCourseIds)
                ->where('course_name', 'LIKE', "%{$search}%")
                ->orwhere('course_instructor', 'LIKE', "%{$search}%")
                ->orwhere('course_tags', 'LIKE', "%{$search}%")
                ->paginate(8);
            $searched = true;
        }

        //Sort and filter
        if ($sort == "A to Z" && $searched == true && $tagFilter == "false") {
            $availableCourses = course::whereIn('course_id', $availableCourseIds)
                ->where('course_name', 'LIKE', "%{$search}%")
                ->orwhere('course_instructor', 'LIKE', "%{$search}%")
                ->orwhere('course_tags', 'LIKE', "%{$search}%")
                ->orderBy("course_name")
                ->paginate(8);
            $sorted = "A to Z";
        } elseif ($sort == "A to Z" && $searched == false && $tagFilter == "false") {
            $availableCourses = course::whereIn('course_id', $availableCourseIds)
                ->orderBy("course_name")
                ->paginate(8);
            $sorted = "A to Z";
        }
        if ($sort == "Z to A" && $searched == true && $tagFilter == "false") {
            $availableCourses = course::whereIn('course_id', $availableCourseIds)
                ->where('course_name', 'LIKE', "%{$search}%")
                ->orwhere('course_instructor', 'LIKE', "%{$search}%")
                ->orwhere('course_tags', 'LIKE', "%{$search}%")
                ->orderBy("course_name", "desc")
                ->paginate(8);
            $sorted = "Z to A";
        } elseif ($sort == "Z to A" && $searched == false && $tagFilter == "false") {
            $availableCourses = course::whereIn('course_id', $availableCourseIds)
                ->orderBy("course_name", "desc")
                ->paginate(8);
            $sorted = "Z to A";
        }
        if ($sort == "Recently Added" && $searched == true && $tagFilter == "false") {
            $availableCourses = course::whereIn('course_id', $availableCourseIds)
                ->where('course_name', 'LIKE', "%{$search}%")
                ->orwhere('course_instructor', 'LIKE', "%{$search}%")
                ->orwhere('course_tags', 'LIKE', "%{$search}%")
                ->paginate(8);
            $sorted = "Recently Added";
        } elseif ($sort == "Recently Added" && $searched == false && $tagFilter == "false") {
            $availableCourses = course::whereIn('course_id', $availableCourseIds)->paginate(8);
            $sorted = "Recently Added";
        }
        // Recently Enrolled Sorting is pending


        if ($sort == "A to Z" && $searched == true && $tagFilter != "false") {
            $availableCourses = course::whereIn('course_id', $availableCourseIds)
                ->where('course_tags', 'LIKE', "%{$tagFilter}%")
                ->where('course_name', 'LIKE', "%{$search}%")
                ->orwhere('course_instructor', 'LIKE', "%{$search}%")
                ->orwhere('course_tags', 'LIKE', "%{$search}%")
                ->orderBy("course_name")
                ->paginate(8);
            $sorted = "A to Z";
        } elseif ($sort == "Z to A" && $searched == true && $tagFilter != "false") {
            $availableCourses = course::whereIn('course_id', $availableCourseIds)
                ->where('course_tags', 'LIKE', "%{$tagFilter}%")
                ->where('course_name', 'LIKE', "%{$search}%")
                ->orwhere('course_instructor', 'LIKE', "%{$search}%")
                ->orwhere('course_tags', 'LIKE', "%{$search}%")
                ->orderBy("course_name", "desc")
                ->paginate(8);
            $sorted = "Z to A";
        } elseif ($sort == "Recently Added" && $searched == true && $tagFilter != "false") {
            $availableCourses = course::whereIn('course_id', $availableCourseIds)
                ->where('course_tags', 'LIKE', "%{$tagFilter}%")
                ->where('course_name', 'LIKE', "%{$search}%")
                ->orwhere('course_instructor', 'LIKE', "%{$search}%")
                ->orwhere('course_tags', 'LIKE', "%{$search}%")
                ->paginate(8);
            $sorted = "Recently Added";
        } elseif ($sort == "A to Z" && $searched == false && $tagFilter != "false") {
            $availableCourses = course::whereIn('course_id', $availableCourseIds)
                ->where('course_tags', 'LIKE', "%{$tagFilter}%")
                ->orderBy("course_name")
                ->paginate(8);
            $sorted = "A to Z";
        } elseif ($sort == "Z to A" && $searched == false && $tagFilter != "false") {
            $availableCourses = course::whereIn('course_id', $availableCourseIds)
                ->where('course_tags', 'LIKE', "%{$tagFilter}%")
                ->orderBy("course_name", "desc")
                ->paginate(8);
            $sorted = "Z to A";
        } elseif ($sort == "Recently Added" && $searched == false && $tagFilter != "false") {
            $availableCourses = course::whereIn('course_id', $availableCourseIds)
                ->where('course_tags', 'LIKE', "%{$tagFilter}%")
                ->paginate(8);
            $sorted = "Recently Added";
        }
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];


        return view('elearning.allCourses', compact('availableCourses', 'availableTags', 'search', 'sort', 'tagFilter', 'progressFilter', 'modules', 'screens', 'menus'));
    }

    public function courseOverview(Request $request, $id)
    {
        //dd($request);
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return redirect(url('/'));
        }
        $id = Crypt::decrypt($id);
        $courseDetails = DB::select("SELECT * FROM elearning_courses WHERE drop_course=0 AND course_id=$id");
        //dd($courseDetails);
        foreach ($courseDetails as $courseDetail) {
            $classOrder = $courseDetail->course_classes;
        }
        $isEnrolled = DB::select("SELECT * FROM user_course_relation WHERE user_id=$user_id AND course_id=$id");
       // dd($isEnrolled);
        if (empty($isEnrolled)) {
            $enrolled = "False";
        } else {
            $enrolled = "True";
        }

        $isEnrolled = DB::select("SELECT * FROM user_class_relation WHERE user_id=$user_id AND class_id=$id");
        if (empty($isEnrolled)) {
            $enrolled = "False";
        } else {
            $enrolled = "True";
        }
       


        $courseContents = DB::select("SELECT * FROM elearning_classes WHERE drop_class=0  ORDER BY FIELD(class_id,$classOrder)");
        // $this->WriteFileLog($courseContents);

        return view('elearning.courseOverview', compact('courseDetails', 'courseContents', 'classOrder', 'enrolled'));
    }

    public function takeCourse(Request $request, $id)
    {
       
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return redirect(url('/'));
        }
        $id = Crypt::decrypt($id);
        $courseDetails = DB::select("SELECT * FROM elearning_courses WHERE drop_course=0 AND course_id=$id");
        foreach ($courseDetails as $courseDetail) {
            $classOrder = $courseDetail->course_classes;
        }
        $isEnrolled = DB::select("SELECT * FROM user_course_relation WHERE user_id=$user_id AND course_id=$id");
        if (empty($isEnrolled)) {
            $userDetails = DB::select("SELECT * FROM users WHERE id=$user_id")[0];
            $userName = $userDetails->name;
            $userMail = $userDetails->email;
            $userMobile = ($userDetails->mobile_no) == null ? 0 : $userDetails->mobile_no;
            // dd($userMobile);
            $courseId = $courseDetails[0]->course_id;
            $courseName = $courseDetails[0]->course_name;
            // $courseBonus = $courseDetails[0]->course_bonus;
            $courseStatus = "Enrolled";
            $courseEnrollDate = date("Y-m-d H:i:s", time());
            $courseProgress = "0";
            $userPointsEarned = "0";
            $userRatingsGiven = "0";
            $mobileRemainder = "0";
            $mailRemainder = "0";
            DB::table('user_course_relation')
                ->insert([
                    'user_id' => "$user_id",
                    'user_name' => "$userName",
                    'user_email' => "$userMail",
                    'user_mobile' => "$userMobile",
                    'course_id' => "$courseId",
                    'course_name' => "$courseName",
                    // 'course_bonus' => "$courseBonus",
                    'course_status' => "$courseStatus",
                    'course_enroll_date' => "$courseEnrollDate",
                    'course_progress' => "$courseProgress",
                    'user_points_earned' => "$userPointsEarned",
                    'user_rating_given' => "$userRatingsGiven",
                    'mobile_remainder' => "$mobileRemainder",
                    'mail_remainder' => "$mailRemainder",
                ]);
            // dd('completed');

            $courseContents = DB::select("SELECT * FROM elearning_classes WHERE drop_class=0  ORDER BY FIELD(class_id,$classOrder)");
            $this->WriteFileLog($courseContents);
            return view('elearning.classoverview', compact('courseDetails', 'courseContents', 'classOrder'));
        } else {
            // 
        }
        $isForum = "False";
        $questionAdded = "False";
        $askedQuestions = DB::select("SELECT * FROM elearning_forum WHERE course_id=$id");
        $noQuestionsYet = empty($askedQuestions) ? true : false;
        // dd(empty($askedQuestions));
        // dd($courseDetails);

       // $courseContents['courseContents'] = DB::select("SELECT * from elearning_courses inner join elearning_classes on elearning_courses.course_classes=elearning_classes.class_id where drop_course = 0;");


        $courseContents = DB::select("SELECT * FROM elearning_classes WHERE drop_class=0  ORDER BY FIELD(class_id,$classOrder)");

        $classContents = DB::select("SELECT * FROM elearning_courses where course_id= $id");
        $class_array= explode(',',$classContents[0]->course_classes);
        $selected_class=[];
        foreach ($class_array as $key=>$value) {
            $classContents = DB::select("SELECT * FROM elearning_classes where class_id= $value ");

            $selected_class[$key]=$classContents[0];

            # code...
        }

       


        return view('elearning.class', compact('courseDetails','classContents','selected_class', 'courseContents', 'classOrder', 'isForum', 'questionAdded', 'askedQuestions', 'noQuestionsYet'));
    }

    public function addWishList(Request $request)
    {
        // Authentication
        $userId = $request->session()->get("userID");
        if ($userId == null) {
            return view('auth.login');
        }
        $courseId = $request->id;
        $wishDate = date("Y-m-d H:i:s", time());
        $isWishListed = DB::select("SELECT * FROM elearning_wishlist WHERE user_id = $userId AND course_id = $courseId");
        // $this->WriteFileLog($isWishListed);
        if (empty($isWishListed)) {
            DB::table('elearning_wishlist')
                ->insert([
                    'user_id' => $userId,
                    'course_id' => $courseId,
                    'wishlist_date' => $wishDate
                ]);
            return "wishlist added";
        } else {
            return "already added";
        }
    }

    // public function wishlist(Request $request, $id)
    // {

    //     dd($request);
    //     $user_id = $request->session()->get("userID");
    //     if ($user_id == null) {
    //         return redirect(url('/'));
    //     }
    //     $id = '15';
    //     $wishlistDetails = DB::select("SELECT * FROM elearning_wishlist WHERE drop_wish=0 AND course_id=$id");
    //     foreach ($wishlistDetails as $wishlistDetail) {
    //         $classOrder = $wishlistDetail->course_id;
    //     }

    //     $wishlistCourses = DB::select("SELECT * FROM elearning_courses WHERE drop_course=0 AND course_id=$id");
       
    //     $courseContents = DB::select("SELECT * FROM elearning_classes WHERE drop_class=0  ORDER BY FIELD(class_id,$classOrder)");
    //     $menus = $this->FillMenu();
    //     $screens = $menus['screens'];
    //     $modules = $menus['modules'];

    //     // $this->WriteFileLog($courseContents);
    //     return view('elearning.wishlist', compact('wishlistDetails', 'courseContents', 'classOrder','menus','screens','modules','wishlistCourses'));
    // }

    public function cart()
    {
        // $courseId = Crypt::decrypt($id);
        // $userId = session()->get("userID");
        // // dd($userId);
        // if ($courseId == "all") {
        //     $coursesInCart = courseCart::where('user_id', $userId);
        //     dd($coursesInCart);
        // } else {
        //     // dd('else');
        //     $previouscourses = courseCart::where('user_id', $userId);
        //     dd($previouscourses);
        //     $previousCourseIds = [];
        // foreach ($previouscourses as $previouscourse) {
        //     array_splice($previousCourseIds, 1, 0, $previouscourse->course_id);
        // }

        //     $time = time();
        //     $currentTime = date("Y-m-d H:i:s", $time);
        //     // dd($currentTime);
        //     $courseCart = new courseCart;
        //     $courseCart->course_id = $courseId;
        //     $courseCart->user_id = $userId;
        //     $courseCart->course_added_date = $currentTime;
        //     $courseCart->save();
        //     // dd("done");
        //     $coursesInCart = courseCart::where('user_id', $userId);
        // }
        return view('elearning.cart');
    }

    public function quiz()
    {

        $maxId = DB::select("select quiz_id from elearning_practice_quiz order by quiz_id desc limit 0,1");
        //dd($maxId);
        $max = $maxId[0]->quiz_id;
        $availableQuizzes = DB::select("select quiz_id from elearning_practice_quiz where drop_quiz=0");
        $availableQuizIds = [];
        foreach ($availableQuizzes as $availableQuiz) {
            array_splice($availableQuizIds, 1, 0, $availableQuiz->quiz_id);
        }
        do {
            $randomNumber = rand(1, $max);
        } while (!(in_array($randomNumber, $availableQuizIds)));
        $randomQuiz = DB::select("select * from elearning_practice_quiz where quiz_id=$randomNumber");
        $quizName = $randomQuiz[0]->quiz_name;
        $quizId = $randomQuiz[0]->quiz_id;
        $questions = explode(", ", $randomQuiz[0]->quiz_questions);
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
                $choices = explode(", ", $questionDetails[$index]->choices);
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
        // dd($qIds);
        return view('elearning.quiz', compact('quizId', 'quizName', 'questionDetails', 'qIds'));
    }

    public function assessmentQuiz()
    {
        $maxId = DB::select("select assessment_id from elearning_assessment order by assessment_id desc limit 0,1");
        $max = $maxId[0]->assessment_id;
        $availableAssessments = DB::select("select assessment_id from elearning_assessment where drop_assessment=0");
        $availableAssessmentIds = [];
        foreach ($availableAssessments as $availableAssessment) {
            array_splice($availableAssessmentIds, 1, 0, $availableAssessment->assessment_id);
        }
        do {
            $randomNumber = rand(1, $max);
        } while (!(in_array($randomNumber, $availableAssessmentIds)));
        $randomAssessments = DB::select("select * from elearning_assessment where assessment_id=$randomNumber");
        $assessmentName = $randomAssessments[0]->assessment_name;
        $assessmentId = $randomAssessments[0]->assessment_id;
        $questions = explode(", ", $randomAssessments[0]->assessment_questions);
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
                $choices = explode(", ", $questionDetails[$index]->choices);
                $questionDetails[$index]->choices = $choices;
            } elseif ($questionType == "short") {
                $questionDetails[$index] = DB::select("select * from elearning_questions_short_answer where question_id=$questionId")[0];
            } elseif ($questionType == "long") {
                $questionDetails[$index] = DB::select("select * from elearning_questions_long_answer where question_id=$questionId")[0];
            }
            $index++;
        }
        // dd($questionDetails);
        return view('elearning.assessment', compact('assessmentId', 'assessmentName', 'questionDetails'));
    }

    public function quizresult(Request $request)
    {
        $quizAttendDate = date("Y-m-d H:i:s", time());
        // Authentication
        $userId = $request->session()->get("userID");
        if ($userId == null) {
            return view('auth.login');
        }
        $id = Crypt::decrypt($request->id);
        $quizDetails = DB::select("select * from elearning_practice_quiz where quiz_id=$id");
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
                if (str_contains($answer, $keywords[0]) && str_contains($answer, $keywords[1])) {
                    $pointsEarned = $availablePoints;
                    $answerStatus = "Full";
                } elseif (str_contains($answer, $keywords[0]) || str_contains($answer, $keywords[1])) {
                    $pointsEarned = $pointPerkeyword;
                    $answerStatus = "Partial";
                } else {
                    $pointsEarned = 0;
                    $answerStatus = "none";
                }
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
                if (str_contains($answer, $keywords[0]) && str_contains($answer, $keywords[1])) {
                    $pointsEarned = $availablePoints;
                    $answerStatus = "Full";
                } elseif (str_contains($answer, $keywords[0]) || str_contains($answer, $keywords[1])) {
                    $pointsEarned = $pointPerkeyword;
                    $answerStatus = "Partial";
                } else {
                    $pointsEarned = 0;
                    $answerStatus = "none";
                }
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
                    'user_id' => $userId,
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

        DB::table('elearning_quiz_results')
            ->insert([
                'user_id' => "$userId",
                'quiz_id' => "$quizId",
                'quiz_name' => "$quizName",
                'questions_ids' => "$questionIds",
                'questions_scores' => "$questionScores",
                'total_scores' => "$totalAvailablePoints",
                'scores_earned' => "$totalPointsEarned",
                'quiz_date' => "$quizAttendDate",
            ]);
        $this->WriteFileLog($data);
        return $data;
    }

    public function assessmentSubmit(Request $request)
    {
        // assessment functionality
        // dd($request);
        $message = "success";
        return view('elearning.', compact('message'));
    }

    public function addQuestion(Request $request, $id)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return redirect(url('/'));
        }
        $isForum = "True";
        $encrypt_id = $id;
        $id = Crypt::decrypt($id);
        $courseDetails = DB::select("SELECT * FROM elearning_courses WHERE drop_course=0 AND course_id=$id");
        foreach ($courseDetails as $courseDetail) {
            $classOrder = $courseDetail->course_classes;
        }
        $isEnrolled = DB::select("SELECT * FROM user_course_relation WHERE user_id=$user_id AND course_id=$id");
        if (empty($isEnrolled)) {
            return view('elearning.dashboard');
        } else {
            // 
        }



        $questionHeading = $request->Question_heading;
        $questionDescription = $request->Question_description;

        $questionDate = date("Y-m-d H:i:s", time());
        // dd($questionImage);
        DB::table('elearning_forum')
            ->insert([
                'course_id' => "$id",
                'class_id' => "0",
                'user_id' => "$user_id",
                'question_date' => "$questionDate",
                'question_header' => "$questionHeading",

                'question_description' => "$questionDescription",
                'number_of_follows' => "0",
                'follow_details' => "",
                'number_of_reply' => "0",
                'reply_details' => "",
            ]);
        $askedQuestions = DB::select("SELECT * FROM elearning_forum WHERE course_id=$id");
        // $forumQuestions = empty($askedQuestions)? $askedQuestions[0]="No Questions has been asked in this course yet": $askedQuestions;
        // dd($forumQuestions);
        $courseContents = DB::select("SELECT * FROM elearning_classes WHERE drop_class=0 AND class_in=$id ORDER BY FIELD(class_id,$classOrder)");
        // dd($courseContents);
        $questionAdded = "True";
        $noQuestionsYet = empty($askedQuestions) ? true : false;
        $this->WriteFileLog($courseContents);
    //     return view('elearning.class', compact('courseDetails', 'courseContents', 'classOrder', 'isForum', 'askedQuestions', 'noQuestionsYet'));
    // 
    return redirect(route('elearningCourse/class', $encrypt_id));

}

    public function result()
    {
        return view('elearning.result');
    }

    public function checkout()
    {

        return view('elearning.result');
    }

    public function addNewNote(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return redirect(url('/'));
        }
        $course_id = $request->courseId;
        $class_id = $request->classId;
        $note_date = date("Y-m-d H:i:s", time());
        $note = $request->note;
        try {
            DB::table('elearning_notes')
                ->insert([
                    'course_id' => "$course_id",
                    'class_id' => "$class_id",
                    'user_id' => "$user_id",
                    'notes_date' => "$note_date",
                    'note' => "$note",
                ]);
            return "Success";
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function viewNotes(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return redirect(url('/'));
        }
        $course_id = $request->courseId;
        try {
            $notes = DB::select("SELECT * FROM elearning_notes WHERE active_note=0 AND course_id=$course_id AND user_id=$user_id");
            $isEmpty = empty($notes) ? true : false;
            $data = [
                'notes' => $notes,
                'isEmpty' => $isEmpty,
            ];
            return $data;
        } catch (\Throwable $th) {
            return $th;
        }
    }


    //iyyappan//

    public function admindashboard(Request $request)
    {
        return view('elearning.admin.admindashboard');
    }


    public function admincourse(Request $request)
    {
        return view('elearning.admin.course.Admincourse');
    }

    public function admincoursecreate(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }

        return view('elearning.admin.course.admincoursecreate');

        dd($request->urd);
        //
    }

    public function adminquiz(Request $request)
    {
        return view('elearning.admin.quiz.adminquiz');
    }

    public function adminquizcreate(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }

        return view('elearning.admin.quiz.adminquizcreate');

        dd($request->urd);
    }

    public function coursepreview(Request $request)
    {
        return view('elearning.admin.coursepreview.Coursepreview');
    }

    public function coursepreviewcreate(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }

        return view('elearning.admin.coursepreview.Coursepreviewcreate');

        dd($request->urd);
        //
    }
    public function adminevent(Request $request)
    {
        return view('elearning.admin.events.adminevent');
    }

    public function admineventcreate(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }

        return view('elearning.admin.events.admineventcreate');

        dd($request->urd);
        //
    }

    public function adminnoticeboard(Request $request)
    {
        return view('elearning.admin.noticeboard.Adminnoticeboard');
    }

    public function adminnoticeboardcreate(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }

        return view('elearning.admin.noticeboard.adminnoticeboardcreate');

        // dd($request->urd);
        //
    }
}
