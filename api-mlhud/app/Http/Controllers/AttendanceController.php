<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\If_;


class AttendanceController extends BaseController
{


    public function getAll(Request $request)
    {
        try {
            $rows['values'] = DB::table('users as u')
                ->join('cpt_points_hours_calculate as c', 'u.id', '=', 'c.user_id')
                ->join('elearning_courses as e', 'c.course_id', '=', 'e.course_id')
                ->join('uam_roles as r', 'u.role_id', '=', 'r.role_id')
                ->leftJoin('designation as d', 'u.designation_id', '=', 'd.designation_id')
                ->whereNotIn('u.role_id', [1, 41])
                ->orderBy('u.id', 'DESC')
                ->select(
                    'u.id as user_id',
                    'u.name as user_name',
                    'u.role_id',               
                    'd.designation_id',        
                    'r.role_name',
                    'd.designation_name',
                    'c.course_id',
                    'e.course_name',
                    'c.start_time',
                    'c.end_time',
                    'c.percentage',
                    'c.hours'
                )
                ->get()
                ->groupBy('user_id')
                ->map(function ($courses) {
                    return $courses->groupBy('course_id');
                });

            $rows['roles'] = DB::table('uam_roles')
                ->whereNotIn('role_id', [1, 41])
                ->orderBy('role_name', 'ASC')
                ->select('role_id', 'role_name')
                ->get();


            $rows['designation'] = DB::table('designation')
                ->orderBy('designation_name', 'ASC')
                ->select('designation_id', 'designation_name', 'role_id')
                ->get();


            $rows['users'] = DB::table('users')
                ->whereNotIn('role_id', [1, 41])
                ->orderBy('name', 'ASC')
                ->select('id', 'name', 'designation_id')
                ->get();

            $rows['courses'] = DB::table('elearning_courses')
                ->select('course_id', 'course_name')
                ->where('drop_course',0)
                ->get();


            $serviceResponse = [];
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = ['rows' => $rows];
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);

            return $this->SendServiceResponse(
                $serviceResponse,
                config('setting.status_code.success'),
                true
            );
        } catch (\Throwable $th) {
            return response()->json([
                'Code' => 500,
                'Message' => 'Internal Server Error',
                'Error' => $th->getMessage()
            ], 500);
        }
    }
}
