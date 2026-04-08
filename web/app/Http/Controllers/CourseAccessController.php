<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Redirect;
use Validator;
use GuzzleHttp\Client;
use DB;
use Illuminate\Support\Facades\Crypt;

class CourseAccessController extends BaseController
{
    public function verifyCoursePin(Request $request)
    {
        $course = DB::table('elearning_courses')
            ->where('id', $request->course_id)
            ->first();

        if (!$course) {
            return response()->json([
                'status' => false,
                'message' => 'Course not found'
            ]);
        }

        // ✅ APPLY EXPIRY CHECK HERE
        if (
            empty($course->course_pin_created_at) ||
            now()->diffInHours($course->course_pin_created_at) >= 24
        ) {
            return response()->json([
                'status' => false,
                'message' => 'Course PIN has expired'
            ]);
        }

        // ✅ PIN MATCH CHECK
        if ($request->course_pin != $course->course_pin) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Course PIN'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Course access granted'
        ]);
    }
}
