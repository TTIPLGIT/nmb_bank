<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class CourseController extends BaseController
{
    public function index(Request $request)
    {
        try {
         $courses = DB::table('elearning_courses as ec')
                ->leftJoin('course_catagory as cc', 'ec.course_category', '=', 'cc.catagory_id')
                ->Join('ai_course_response as ac', function ($join) {
                    $join->on('ec.course_id', '=', 'ac.course_id')
                        ->where('ac.is_published', 1);
                })
                ->select('ec.*', 'cc.catagory_name')
                ->where('ec.drop_course', '0')
                ->orderBy('ec.course_id', 'desc')
                ->get();

            $classes = DB::table('elearning_classes')
                ->where('drop_class', '0')
                ->orderBy('class_id', 'desc')
                ->get();

            $courseCategories = DB::table('course_catagory')
                ->where('active_flag', '0')
                ->orderBy('catagory_id', 'desc')
                ->get();

            $designations = DB::table('designation')
                ->orderBy('designation_id', 'desc')
                ->get();

            $users = DB::table('users')
                ->orderBy('id', 'desc')
                ->get();

            $roles = DB::table('uam_roles')
                ->where('active_flag', 0)
                ->get();

            $examList = DB::table('elearning_exam')
                ->where('active_flag', '0')
                ->orderBy('id', 'desc')
                ->get();

            $quizDropdown = DB::select("SELECT e.* from elearning_practice_quiz AS e 
                LEFT JOIN elearning_localadaptation AS l ON e.quiz_id = l.quiz_id 
                LEFT JOIN elearning_ethnictest AS et ON e.quiz_id = et.quiz_id 
                LEFT JOIN elearning_exam AS el ON e.quiz_id = el.quiz_id 
                WHERE l.quiz_id IS NULL AND e.drop_quiz = 0");

            $certificateTemplates = DB::select("SELECT * FROM certificate_templates WHERE active_flag = '0'");

            $menus = $this->FillMenu();
            $screens = $menus['screens'] ?? [];
            $modules = $menus['modules'] ?? [];

            return view('elearning.admin.course.index', compact(
                'courses', 'classes', 'courseCategories', 'designations', 'users', 
                'roles', 'examList', 'quizDropdown', 'certificateTemplates', 
                'screens', 'modules'
            ));
        } catch (\Exception $exc) {
            return redirect()->back()->with('error', $exc->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'course_banner' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'course_introduction' => 'required|file|mimetypes:video/mp4,audio/mpeg,image/png,image/jpeg|max:51200',
                'course_name' => 'required|string|max:255',
                'course_description' => 'required|string',
                'course_instructor' => 'required|string|max:255',
                'course_category_id' => 'required',
                'role_id' => 'required',
                'designation_id' => 'required',
                'user_ids' => 'required',
                'course_certificate' => 'required',
                'course_pay' => 'required',
                'course_cpt_points' => 'required|numeric',
                'course_classes' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $user_id = auth()->user()->id;
            $storagePath = public_path() . '/uploads/course/' . $user_id;
            $dbPath = '/uploads/course/' . $user_id;

            if (!File::exists($storagePath)) {
                File::makeDirectory($storagePath, 0777, true, true);
            }

            // Handle tags and arrays
            $courseTags = $request->course_tags ? implode(', ', $request->course_tags) : '';
            $courseSkills = $request->course_skills_required ? implode(', ', $request->course_skills_required) : '';
            $courseGainSkills = $request->course_gain_skills ? implode(', ', $request->course_gain_skills) : '';
            $courseClasses = $request->course_classes ? implode(', ', $request->course_classes) : '';
            $userIds = $request->user_ids ? implode(',', $request->user_ids) : '';

            // Handle file uploads
            $bannerName = $this->uploadFile($request->file('course_banner'), $storagePath);
            $introductionName = $this->uploadFile($request->file('course_introduction'), $storagePath);
            
            $summaryName = null;
            if ($request->hasFile('course_summary')) {
                $summaryName = $this->uploadFile($request->file('course_summary'), $storagePath);
            }

            $introductionExtension = pathinfo($introductionName, PATHINFO_EXTENSION);

            $courseId = DB::table('elearning_courses')->insertGetId([
                'course_banner' => $bannerName,
                'course_summary' => $summaryName,
                'course_name' => $request->course_name,
                'course_instructor' => $request->course_instructor,
                'exam_id' => $request->exam_name ?? null,
                'exam_date' => $request->exam_date,
                'course_noperiod' => $request->course_noperiod ?? 2,
                'pass_percentage' => $request->pass_percentage,
                'course_start_period' => $request->course_start_period,
                'course_end_period' => $request->course_end_period,
                'course_pay' => $request->course_pay,
                'course_price' => $request->course_price ?? 0,
                'course_description' => $request->course_description,
                'course_certificate' => $request->course_certificate,
                'course_exam' => $request->course_exam ?? 2,
                'course_introduction' => $introductionName,
                'introduction_path' => $dbPath,
                'banner_path' => $dbPath,
                'summary_path' => $dbPath,
                'course_tags' => $courseTags,
                'course_skills_required' => $courseSkills,
                'course_gain_skills' => $courseGainSkills,
                'course_classes' => $courseClasses,
                'course_cpt_points' => $request->course_cpt_points,
                'course_category' => $request->course_category_id,
                'course_format' => $introductionExtension,
                'cetificate_template' => $request->cetificate_template,
                'certificate_expiry' => $request->certificate_expiry ?? 2,
                'course_expiry_period' => $request->course_expiry_period,
                'expired_course_id' => $request->expired_course_id,
                'role_id' => $request->role_id,
                'designation_id' => $request->designation_id,
                'user_ids' => $userIds,
                'restricted_access' => $request->restricted_access ?? 0,
                'course_pin' => $request->restricted_access == 1 ? rand(100000, 999999) : null,
                'course_pin_created_at' => $request->restricted_access == 1 ? now() : null,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect()->route('admin.courses.index')->with('success', 'Course created successfully');
        } catch (\Exception $exc) {
            return redirect()->back()->with('error', $exc->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $courseId = Crypt::decrypt($id);
            
            $course = DB::table('elearning_courses')
                ->where('course_id', $courseId)
                ->first();

            if (!$course) {
                return redirect()->route('admin.courses.index')->with('error', 'Course not found');
            }

            $categories = DB::table('course_catagory')
                ->where('active_flag', '0')
                ->get();

            $classes = DB::table('elearning_classes')
                ->where('drop_class', '0')
                ->get();

            $roles = DB::table('uam_roles')->where('active_flag', 0)->get();
            $designations = DB::table('designation')->get();
            $users = DB::table('users')->get();

            return view('admin.course.edit', compact('course', 'categories', 'classes', 'roles', 'designations', 'users'));
        } catch (\Exception $exc) {
            return redirect()->route('admin.courses.index')->with('error', $exc->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $courseId = Crypt::decrypt($id);
            
            $updateData = [
                'course_name' => $request->course_name,
                'course_description' => $request->course_description,
                'course_instructor' => $request->course_instructor,
                'course_pay' => $request->course_pay,
                'course_price' => $request->course_price ?? 0,
                'course_cpt_points' => $request->course_cpt_points,
                'course_category' => $request->course_category_id,
                'course_certificate' => $request->course_certificate,
                'course_exam' => $request->course_exam ?? 2,
                'course_noperiod' => $request->course_noperiod ?? 2,
                'restricted_access' => $request->restricted_access ?? 0,
                'updated_at' => now()
            ];

            if ($request->restricted_access == 1 && !$request->course_pin) {
                $updateData['course_pin'] = rand(100000, 999999);
                $updateData['course_pin_created_at'] = now();
            }

            if ($request->has('user_ids')) {
                $updateData['user_ids'] = implode(',', $request->user_ids);
            }
            if ($request->has('course_classes')) {
                $updateData['course_classes'] = implode(', ', $request->course_classes);
            }
            if ($request->has('course_tags')) {
                $updateData['course_tags'] = implode(', ', $request->course_tags);
            }
            if ($request->has('course_skills_required')) {
                $updateData['course_skills_required'] = implode(', ', $request->course_skills_required);
            }
            if ($request->has('course_gain_skills')) {
                $updateData['course_gain_skills'] = implode(', ', $request->course_gain_skills);
            }

            $user_id = auth()->user()->id;
            $storagePath = public_path() . '/uploads/course/' . $user_id;

            if ($request->hasFile('course_banner')) {
                $updateData['course_banner'] = $this->uploadFile($request->file('course_banner'), $storagePath);
                $updateData['banner_path'] = '/uploads/course/' . $user_id;
            }

            if ($request->hasFile('course_introduction')) {
                $updateData['course_introduction'] = $this->uploadFile($request->file('course_introduction'), $storagePath);
                $updateData['introduction_path'] = '/uploads/course/' . $user_id;
                $updateData['course_format'] = pathinfo($updateData['course_introduction'], PATHINFO_EXTENSION);
            }

            DB::table('elearning_courses')
                ->where('course_id', $courseId)
                ->update($updateData);

            return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully');
        } catch (\Exception $exc) {
            return redirect()->back()->with('error', $exc->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $courseId = Crypt::decrypt($id);
            
            $course = DB::table('elearning_courses')
                ->where('course_id', $courseId)
                ->first();

            if (!$course) {
                return redirect()->route('admin.courses.index')->with('error', 'Course not found');
            }

            return view('admin.course.show', compact('course'));
        } catch (\Exception $exc) {
            return redirect()->route('admin.courses.index')->with('error', $exc->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            $courseId = $request->course_id;
            
            // Check dependencies
            $hasEnrollments = DB::table('user_course_relation')
                ->where('course_id', $courseId)
                ->exists();

            if ($hasEnrollments) {
                return response()->json([
                    'data' => 0,
                    'message_cus' => 'This course has enrolled users and cannot be deleted'
                ]);
            }

            DB::table('elearning_courses')
                ->where('course_id', $courseId)
                ->update(['drop_course' => '1']);

            return response()->json(['data' => 1]);
        } catch (\Exception $exc) {
            return response()->json(['data' => 0, 'message_cus' => $exc->getMessage()]);
        }
    }

    public function copy(Request $request)
    {
        try {
            $originalCourse = DB::table('elearning_courses')
                ->where('course_id', $request->course_id)
                ->first();

            if ($originalCourse) {
                $newCourseData = (array) $originalCourse;
                unset($newCourseData['course_id']);
                $newCourseData['expired_course_id'] = $request->course_id;
                $newCourseData['course_expiry_period'] = $request->course_expiry_period;
                $newCourseData['certificate_expiry'] = $request->certificate_expiry ?? 2;
                $newCourseData['drop_course'] = '0';
                $newCourseData['created_at'] = now();
                $newCourseData['updated_at'] = now();

                DB::table('elearning_courses')->insert($newCourseData);
            }

            return response()->json(['data' => 1]);
        } catch (\Exception $exc) {
            return response()->json(['data' => 0, 'message_cus' => $exc->getMessage()]);
        }
    }

    private function uploadFile($file, $path)
    {
        $filename = str_replace([' ', '&', "'", '"'], '-', $file->getClientOriginalName());
        $file->move($path, $filename);
        return $filename;
    }
}