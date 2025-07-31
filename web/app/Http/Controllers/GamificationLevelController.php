<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class GamificationLevelController extends BaseController
{
    public function index(Request $request)
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
        $gatewayURL = config('setting.api_gateway_url') . '/level/getAll';
        $allRecords['levels'] = DB::table('gamification_levels')
            ->where('active_flag', 1)
            ->orderBy('level_id', 'desc')
            ->get();

        $response = json_decode($this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method));
        if ($response->Status == 200 && $response->Success) {
            $objData = json_decode($this->decryptData($response->Data));
            $parant_data = json_decode(json_encode($objData->Data), true);
            $levels = $parant_data['levels'];
            // dd($levels);
        }
        return view("Gamifications.levels", compact('screens', 'modules', 'levels', 'allRecords'));
    }

    public function createpage(Request $request)
    {

        $menus = $this->FillMenu();

        $screens = $menus['screens'];
        $modules = $menus['modules'];
        $allRecords['levels'] = DB::table('gamification_levels')
            ->where('active_flag', 1)
            ->orderBy('level_id', 'desc')
            ->get();
        return view("Gamifications.createlevels", compact('screens', 'modules', 'allRecords'));
    }
    public function store(Request $request)
    {


        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $menus = $this->FillMenu();
            $method = 'Method =>GamificationLevelController => store';

            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session expired');
            }
            $data = [
                'level_number' => $request->level_number,
                'level_name' => $request->level_name,
                'min_point' => $request->min_point,
                'max_point' => $request->max_point,
                'level_icon' => $request->level_icon,
            ];
            $min_point = $data['min_point'];
            $max_point = $data['max_point'];


            $max_min_errors = DB::table('gamification_levels')
                ->where('active_flag', 1)
                ->where(function ($query) use ($min_point, $max_point) {
                    $query->whereBetween('min_point', [$min_point, $max_point])
                        ->orWhereBetween('max_point', [$min_point, $max_point])
                        ->orWhere(function ($query2) use ($min_point, $max_point) {
                            $query2->where('min_point', '<=', $min_point)
                                ->where('max_point', '>=', $max_point);
                        });
                })
                ->first();

            if ($max_min_errors) {
                session()->flash('fail', 'Minimum and Maximum Range is already Available');
                return back();
            }


            $encryptArray = $this->encryptData($data);
            $requestPayload = ['requestData' => $encryptArray];

            $gatewayURL = config('setting.api_gateway_url') . '/level_create_store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($requestPayload), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    return redirect()->route('level_master_page')->with('success', 'Level created successfully.');
                }

                return back()->with('fail', $objData->Message ?? 'Unknown error');
            }
            if ($response1->Status == 409) {
                $objData = json_decode($this->decryptData($response1->Data));
                return back()->with('fail', $objData->Message ?? ' Something went wrong Please try again later');
            }




            return redirect()->route('level_master_page');
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function show(Request $request)
    {

        $this->WriteFileLog($request);
        try {
            $this->WriteFileLog("feef");
            $method = 'Method =>GamificationLevelController => show';

            $data['level_id'] = $request->level_id;
            $this->WriteFileLog($data['level_id']);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $this->WriteFileLog($data);
            $gatewayURL = config('setting.api_gateway_url') . '/level_show';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $this->WriteFileLog($response);
            $response1 = json_decode($response);
            $objData = json_decode($this->decryptData($response1->Data));
            $rows = json_decode(json_encode($objData->Data), true);
            return $rows;
        } catch (\Exception $exc) {
            //echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function update(Request $request)
    {
        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $menus = $this->FillMenu();
            $method = 'Method => GamificationLevelController => update';

            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session expired');
            }

            $newMin = $request->min_point;
            $newMax = $request->max_point;
            $currentId = $request->level_id;

            $isOverlapping = DB::table('gamification_levels')
                ->where('level_id', '!=', $currentId)
                ->where('active_flag', 1)
                ->where(function ($query) use ($newMin, $newMax) {
                    $query->where('min_point', '<=', $newMax)
                        ->where('max_point', '>=', $newMin);
                })
                ->exists();


            if ($isOverlapping) {
                return back()->with('fail', 'Minimum and Maximum Range is already available.  Try another');
            }


            $data = [
                'level_id' => $request->level_id,
                'level_name' => $request->level_name,
                'level_number' => $request->level_number,
                'max_point' => $request->max_point,
                'min_point' => $request->min_point,
                'level_icon' => $request->level_icon,
            ];

            $encryptArray = $this->encryptData($data);
            $requestPayload = ['requestData' => $encryptArray];

            $gatewayURL = config('setting.api_gateway_url') . '/level_update';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($requestPayload), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    return redirect()->route('level_master_page')->with('success', 'Level Updated successfully.');
                }

                return back()->with('fail', 'Not added: ' . ($objData->Message ?? 'Unknown error'));
            }

            return redirect()->route('level_master_page');
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }

        return redirect()->route('level_master_page');
    }

    public function level_delete(Request $request)

    { {

            try {
                $user_id = $request->session()->get("userID");
                if ($user_id == null) {
                    return view('auth.login');
                }

                $menus = $this->FillMenu();
                $method = 'Method => GamificationLevelController => level_delete';

                if ($menus == "401") {
                    return redirect(url('/'))->with('danger', 'User session expired');
                }
                $data = [
                    'level_id' => $request->level_id,
                    'level_number' => $request->level_number,
                    'level_name' => $request->level_name,
                    'max_point' => $request->max_point,
                    'min_point' => $request->min_point,
                    'level_icon' => $request->level_icon,

                ];

                $encryptArray = $this->encryptData($data);
                $requestPayload = ['requestData' => $encryptArray];

                $gatewayURL = config('setting.api_gateway_url') . '/level_delete';

                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($requestPayload), $method);

                $response1 = json_decode($response);

                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));

                    if ($objData->Code == 200) {
                        return redirect()->route('level_master_page')->with('success', 'Level Deleted successfully.');
                    }

                    return back()->with('fail', 'Not added: ' . ($objData->Message ?? 'Unknown error'));
                }

                return redirect()->route('level_master_page');
            } catch (\Exception $exc) {
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
            }
            return redirect()->route('level_master_page');
        }
    }

    public function leaderboard(Request $request)
    {
        $menus = $this->FillMenu();
        $user_id = $request->session()->get("userID");
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        $rows['course_catagory'] = DB::table('course_catagory')->orderBy('catagory_id', 'desc')->get();
        $rows['elearning_courses'] = DB::table('elearning_courses')->orderBy('course_id', 'desc')->get();
        $rows['role'] = DB::table('uam_roles')->get();
        $rows['designation'] = DB::table('designation')->orderBy('designation_id', 'desc')->get();

        session()->flash('show_gif', true);


        $query = DB::table('user_cpt_points')
            ->join('users', 'users.id', '=', 'user_cpt_points.user_id')
            ->leftJoin('cpt_points_hours_calculate', function ($join) {
                $join->on('users.id', '=', 'cpt_points_hours_calculate.user_id')
                    ->on('user_cpt_points.course_id', '=', 'cpt_points_hours_calculate.course_id');
            })
            ->leftJoin('elearning_courses', 'elearning_courses.course_id', '=', 'user_cpt_points.course_id')
            ->select(
                'user_cpt_points.course_id',
                'users.id as id',
                'users.name',
                'users.profile_image',
                DB::raw('SUM(cpt_points_hours_calculate.hours) as total_hours'),
                DB::raw('SUM(user_cpt_points.cpt_points) as total_points')
            )
            ->groupBy(
                'user_cpt_points.course_id',
                'users.id',
                'users.name',
                'users.profile_image'
            );

        $rows['results'] = $query->get();
        $rows['leaderboard'] = $query->orderByDesc('total_points')->get();
        $rows['top3'] = $rows['leaderboard']->take(3);
        session()->forget('first_time_leaderboard');

        $rank = 1;
        $currentUserRank = null;
        foreach ($rows['leaderboard'] as $user) {
            if ($user->id == $user_id) {
                $currentUserRank = [
                    'rank' => $rank,
                    'name' => $user->name,
                    'points' => $user->total_points,
                    'profile_image' => $user->profile_image,
                    'total_hours' => $user->total_hours,
                ];
                break;
            }
            $rank++;
        }
        
        $rows['metric_type']="points";

        return view("Gamifications.leaderboard", compact('screens', 'modules', 'user_id', 'rows', 'currentUserRank'));
    }
    public function leaderboardcondition(Request $request)
    {
        $menus = $this->FillMenu();
        $user_id = $request->session()->get("userID");
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        session()->flash('show_gif', true);

        $role = $request->input('role');
        $designation = $request->input('designation');
        $course_catagory = $request->input('course_catagory');
        $metric = $request->input('metric_type');
        $filter = $request->input('filter', 'ALL');

        $rows['course_catagory'] = DB::table('course_catagory')->orderBy('catagory_id', 'desc')->get();
        $rows['elearning_courses'] = DB::table('elearning_courses')->orderBy('course_id', 'desc')->get();
        $rows['role'] = DB::table('uam_roles')->get();
        $rows['designation'] = DB::table('designation')->orderBy('designation_id', 'desc')->get();

        $userIds = null;
        if (!empty($course_catagory)) {
            $course = DB::table('elearning_courses')
                ->where('course_id', $course_catagory)
                ->select('user_ids')
                ->first();

            if ($course && !empty($course->user_ids)) {
                $userIds = array_map('intval', explode(',', $course->user_ids));
            } else {
                $userIds = [];
            }
        }

        if ($metric === 'hours') {
            $query = DB::table('cpt_points_hours_calculate')
                ->join('users', 'users.id', '=', 'cpt_points_hours_calculate.user_id')
                ->join('user_cpt_points', function ($join) {
                    $join->on('users.id', '=', 'user_cpt_points.user_id')
                        ->on('cpt_points_hours_calculate.course_id', '=', 'user_cpt_points.course_id');
                })
                ->join('elearning_courses', 'elearning_courses.course_id', '=', 'cpt_points_hours_calculate.course_id')
                ->select(
                    'cpt_points_hours_calculate.course_id',
                    'users.id as id',
                    'users.profile_image',
                    'users.name',
                    DB::raw('SUM(cpt_points_hours_calculate.hours) as total_hours'),
                    DB::raw('SUM(user_cpt_points.cpt_points) as total_points')
                )
                ->groupBy(
                    'cpt_points_hours_calculate.course_id',
                    'users.id',
                    'users.name',
                    'users.profile_image'
                );



            if (!empty($role)) {
                $query->where('users.role_id', $role);
            }
            if (!empty($designation)) {
                $query->where('users.designation_id', $designation);
            }
            if ($userIds !== null) {
                $query->whereIn('users.id', $userIds);
            }
        } else {
            $query = DB::table('user_cpt_points')
                ->join('users', 'users.id', '=', 'user_cpt_points.user_id')
                ->select(
                    'users.id',
                    'users.name',
                    'users.profile_image',
                    DB::raw('SUM(user_cpt_points.cpt_points) as total_points')
                )
                ->groupBy('users.id', 'users.name');

            if (!empty($role)) {
                $query->where('users.role_id', $role);
            }
            if (!empty($designation)) {
                $query->where('users.designation_id', $designation);
            }
            if ($userIds !== null) {
                $query->whereIn('users.id', $userIds);
            }
        }

        if ($metric === 'hours') {
            $query->orderBy('total_hours', 'asc');
        } else {
            $query->orderByDesc('total_points');
        }

        $rows['leaderboard'] = $query->get();
        $rows['results'] = $rows['leaderboard'];
        $rows['top3'] = $rows['leaderboard']->take(3);

        session()->forget('first_time_leaderboard');

        $rank = 1;
        $currentUserRank = null;
        foreach ($rows['leaderboard'] as $user) {
            if ($user->id == $user_id) {
                $currentUserRank = [
                    'rank' => $rank,
                    'name' => $user->name,
                    'points' => $metric === 'hours' ? $user->total_hours : $user->total_points,
                ];
                break;
            }
            $rank++;
        }

        $filterMessage = [];

        if ($role) {
            $roleName = DB::table('uam_roles')->where('role_id', $role)->value('role_name');
            $filterMessage[] = "Role: <strong>{$roleName}</strong>";
        }
        if ($designation) {
            $designationName = DB::table('designation')->where('designation_id', $designation)->value('designation_name');
            $filterMessage[] = "Designation: <strong>{$designationName}</strong>";
        }
        if ($course_catagory) {
            $courseName = DB::table('elearning_courses')->where('course_id', $course_catagory)->value('course_name');
            $filterMessage[] = "Course: <strong>{$courseName}</strong>";
        }
        if ($metric) {
            $metricLabel = $metric === 'hours' ? 'Hours ' : 'Points ';
            $filterMessage[] = "Based on : <strong>{$metricLabel}</strong>";
        }

        $filterMessageText = $filterMessage ? 'Leaderboard by: ' . implode(', ', $filterMessage) : null;

        $rows['metric_type'] = $metric;

        return view("Gamifications.leaderboard", compact('screens', 'modules', 'user_id', 'rows', 'currentUserRank', 'filterMessageText'));
    }
    public function getLeaderboardData(Request $request)
    {
        $filter = $request->query('filter', 'ALL');
        $metric = $request->query('metric_type', 'points');

        $metricColumn = $metric === 'hours'
            ? 'SUM(cpt_points_hours_calculate.hours)'
            : 'SUM(user_cpt_points.cpt_points)';

        if ($filter === 'ALL') {
            $query = DB::table('user_cpt_points')
                ->join('users', 'users.id', '=', 'user_cpt_points.user_id')
                ->leftJoin('cpt_points_hours_calculate', function ($join) {
                    $join->on('users.id', '=', 'cpt_points_hours_calculate.user_id')
                        ->on('user_cpt_points.course_id', '=', 'cpt_points_hours_calculate.course_id');
                })
                ->leftJoin('elearning_courses', 'elearning_courses.course_id', '=', 'user_cpt_points.course_id')
                ->select(
                    'users.id as id',
                    'users.name',
                    'users.profile_image',
                    DB::raw($metricColumn . ' as total_metric')
                )
                ->groupBy('users.id', 'users.name', 'users.profile_image')
                ->orderByDesc('total_metric');

            $rows = $query->get();
        } else {
            $query = DB::table('user_cpt_points')
                ->join('users', 'users.id', '=', 'user_cpt_points.user_id')
                ->leftJoin('cpt_points_hours_calculate', function ($join) {
                    $join->on('users.id', '=', 'cpt_points_hours_calculate.user_id')
                        ->on('user_cpt_points.course_id', '=', 'cpt_points_hours_calculate.course_id');
                })
                ->select(
                    'users.id',
                    'users.name',
                    'users.profile_image',
                    DB::raw($metricColumn . ' as total_metric')
                )
                ->groupBy('users.id', 'users.name', 'users.profile_image');

            if ($filter === 'WEEKLY') {
                if ($metric === 'hours') {
                    $query->whereBetween('cpt_points_hours_calculate.created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                } else {
                    $query->whereBetween('user_cpt_points.created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                }
            } elseif ($filter === 'MONTHLY') {
                if ($metric === 'hours') {
                    $query->whereMonth('cpt_points_hours_calculate.created_at', now()->month)
                        ->whereYear('cpt_points_hours_calculate.created_at', now()->year);
                } else {
                    $query->whereMonth('user_cpt_points.created_at', now()->month)
                        ->whereYear('user_cpt_points.created_at', now()->year);
                }
            }

            $query->orderByDesc('total_metric');

            $rows = $query->get();
        }

        return response()->json([
            'top3' => $rows->take(3),
            'rankList' => $rows->skip(3)->values()
        ]);
    }
}
