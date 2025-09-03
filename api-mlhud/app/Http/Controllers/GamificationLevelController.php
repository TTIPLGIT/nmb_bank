<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\If_;

class GamificationLevelController extends BaseController
{



    public function store(Request $request)
    {
        try {
            $this->WriteFileLog($request);

            $method = 'Method => GaminficationLevelController => store';
            $inputArray = $request->requestData;
            $inputArray = $this->decryptData($inputArray);

            $input = [
                'level_number' => $inputArray['level_number'],
                'level_name' => $inputArray['level_name'],
                'min_point' => $inputArray['min_point'],
                'max_point' => $inputArray['max_point'],
                'level_icon' => $inputArray['level_icon'],
            ];

            $levels['number'] = DB::table('gamification_levels')
                ->where('level_number', $input['level_number'])

                ->where('active_flag', 1)
                ->exists();
            $levels['name'] = DB::table('gamification_levels')
                ->where('level_name', $input['level_name'])
                ->where('active_flag', 1)
                ->exists();

            $error_message = "";

            if ($levels['number']) {
                $error_message = 'Level Number already exists please try another number';
            } else if ($levels['name']) {
                $error_message = 'Level Name already exists  please try another name';
            }

            if (!empty($error_message)) {
                $serviceResponse = [
                    'Code' => 409,
                    'Message' => $error_message,
                    'Data' => null
                ];

                return $this->SendServiceResponse(
                    json_encode($serviceResponse, JSON_FORCE_OBJECT),
                    409,
                    false
                );
            }

            $rows = DB::table('gamification_levels')->insertGetId([
                'level_number' => $input['level_number'],
                'level_name' => $input['level_name'],
                'min_point' => $input['min_point'],
                'max_point' => $input['max_point'],
                'level_icon' => $input['level_icon'],
                'created_at' => NOW(),
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            $this->notifications_insert(null, auth()->user()->id, "Level Created Successfully", "/level_master_page");

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur 
                                 INNER JOIN users us ON (us.array_roles=ur.role_id) 
                                 WHERE us.id=" . auth()->user()->id);

            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog($input['level_name'], $rows, 'Create', 'Level Created Successfully', auth()->user()->id, NOW(), $role_name_fetch);

            $serviceResponse = [
                'Code' => config('setting.status_code.success'),
                'Message' => config('setting.status_message.success'),
                'Data' => $rows
            ];

            return $this->SendServiceResponse(json_encode($serviceResponse, JSON_FORCE_OBJECT), config('setting.status_code.success'), true);
        } catch (\Exception $exc) {
            $exceptionResponse = [
                'ServiceMethod' => $method,
                'Exception' => $exc->getMessage()
            ];
            $this->WriteFileLog(json_encode($exceptionResponse, JSON_FORCE_OBJECT));

            $serviceResponse = [
                'Code' => config('setting.status_code.exception'),
                'Message' => $exc->getMessage()
            ];
            return $this->SendServiceResponse(json_encode($serviceResponse, JSON_FORCE_OBJECT), config('setting.status_code.exception'), false);
        }
    }


    public function show(Request $request)
    {

        $method = 'Method => GamificationLevelController =>show';
        try {

            $userID = auth()->user()->level_id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'level_id' => $inputArray['level_id'],
            ];
            $level_id = $input['level_id'];

            $rows = DB::select("SELECT * FROM gamification_levels WHERE level_id = ?", [$level_id]);
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
    public function update(Request $request)
    {
        try {
            // $this->WriteFileLog($request);

            $method = 'Method => GamificationLevelController => update';
            $inputArray = $request->requestData;

            $inputArray = $this->decryptData($inputArray);
            $input = [
                'level_id' => $inputArray['level_id'],
                'level_name' => $inputArray['level_name'],
                'level_number' => $inputArray['level_number'],
                'max_point' => $inputArray['max_point'],
                'min_point' => $inputArray['min_point'],
                'level_icon' => $inputArray['level_icon'],
            ];
            $this->WriteFileLog($input);


            $level_id = $input['level_id'];

            $rows = DB::table('gamification_levels')
                ->where('level_id', $level_id)
                ->update([
                    'level_name' => $input['level_name'],
                    'level_number' => $input['level_number'],
                    'max_point' => $input['max_point'],
                    'min_point' => $input['min_point'],
                    'level_icon' => $input['level_icon'],
                ]);

            $this->notifications_insert(null, auth()->user()->id, "Level  Updated Successfully", "/level_master_page");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('Gamification Level', $rows, 'Create', 'Level  Updation', auth()->user()->id, NOW(), $role_name_fetch);

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $rows;
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

    public function getAll(Request $request)
    {
        $method = 'Method => GamificationLevelController => getAll';
        try {
            $allRecords['levels'] = DB::table('gamification_levels')
                ->where('active_flag', 1)
                ->orderBy('level_id', 'desc')
                ->get();

            $this->WriteFileLog($allRecords['levels']);



            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $allRecords;
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
    public function delete(Request $request)
    {
        try {
            $this->WriteFileLog($request);

            $method = 'Method => GamificationLevelController => delete';
            $inputArray = $request->requestData;

            $inputArray = $this->decryptData($inputArray);
            $input = [
                'level_id' => $inputArray['level_id'],
            ];


            $level_id = $input['level_id'];

            $rows = DB::table('gamification_levels')
                ->where('level_id', $level_id)
                ->update([

                    'active_flag' => 0,
                ]);



            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $rows;
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
    public function leaderboard(Request $request)
    {
        $method = 'Method => GamificationLeaderboardController => leaderboard';
        try {
            $inputArray = $this->decryptData($request->requestData);

            $user_id = $inputArray['user_id'];
            $course_id = $inputArray['course_id'] ?? null;
            $metric = $inputArray['metric'] ?? 'points';

            $metricColumn = $metric === 'hours'
                ? 'SUM(cpt_points_hours_calculate.hours)'
                : 'SUM(user_cpt_points.cpt_points)';

            // main query
            $leaderboard = DB::table('user_cpt_points')
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
                    DB::raw($metricColumn . ' as total_metric'),
                    DB::raw('SUM(cpt_points_hours_calculate.hours) as total_hours'),
                    DB::raw('SUM(user_cpt_points.cpt_points) as total_points')
                )
                ->groupBy('users.id', 'users.name', 'users.profile_image')
                ->orderByDesc('total_metric')
                ->get();

            // levels
            // after $leaderboard query
            $leaderboard = $leaderboard->values();

            // Find current user's rank
            $currentUserRank = null;
            foreach ($leaderboard as $index => $user) {
                if ($user->id == $user_id) {
                    $currentUserRank = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'points' => $user->total_points,
                        'hours' => $user->total_hours,
                        'rank' => $index + 1 // because index is 0-based
                    ];
                    break;
                }
            }

            $levels = DB::table('gamification_levels')->orderBy('min_point')->get();
            $uamRoles = DB::table('uam_roles')->get();
            $designaiton = DB::table('designation')->get();
            $elearning_courses = DB::table('elearning_courses')->get();
            $default_level_icon = $levels->first()->level_icon ?? null;

            foreach ($leaderboard as $user) {
                $level = DB::table('gamification_levels')
                    ->where('min_point', '<=', $user->total_points)
                    ->where('max_point', '>=', $user->total_points)
                    ->first();

                $user->level_name = $level->level_name ?? 'N/A';
                $user->level_icon = $level->level_icon ?? $default_level_icon;
            }


            $rewardsGrouped = DB::table('user_course_rewards_strikes')
                ->select('reward_type', 'reward_name', 'icon', 'user_id')
                ->orderBy('id', 'desc')
                ->get()
                ->groupBy('user_id');


            $enrichedLeaderboard = $leaderboard->transform(function ($user) use ($rewardsGrouped, $levels, $default_level_icon) {


                $userRewards = $rewardsGrouped->get($user->id, collect());
                $user->badges  = $userRewards->where('reward_type', 'badge')->values();
                $user->streaks = $userRewards->where('reward_type', 'streak')->values();


                $level = $levels->first(function ($lvl) use ($user) {
                    return $lvl->min_point <= $user->total_points && $lvl->max_point >= $user->total_points;
                });

                $user->level_name = $level->level_name ?? 'N/A';
                $user->level_icon = $level->level_icon ?? $default_level_icon;

                return $user;
            });

            $response = [
                'screens' => [],
                'modules' => [],
                'user_id' => $user_id,
                'rows' => [
                    'leaderboard' => [
                        'leaderboard' => $enrichedLeaderboard,
                        'rewardsGrouped' => $rewardsGrouped
                    ],
                    'top3' => $leaderboard->take(3),
                    'metric_type' => $metric,
                    'role' => $uamRoles,
                    'designation' => $designaiton,
                    'elearning_courses' => $elearning_courses,
                    'level_icon' => $default_level_icon,
                    'rewardsGrouped' => $rewardsGrouped,
                    'currentUserRank' => $currentUserRank
                ],
                'rewardedUserId' => $user_id,
            ];

            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response;

            return $this->SendServiceResponse(json_encode($serviceResponse, JSON_FORCE_OBJECT), config('setting.status_code.success'), true);
        } catch (\Exception $exc) {
            $exceptionResponse = [
                'ServiceMethod' => $method,
                'Exception' => $exc->getMessage(),
            ];
            $this->WriteFileLog(json_encode($exceptionResponse));

            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();

            return $this->SendServiceResponse(json_encode($serviceResponse, JSON_FORCE_OBJECT), config('setting.status_code.exception'), false);
        }
    }
    public function leaderboardCondition(Request $request)
    {
        $method = 'Method => GamificationLevelController => leaderboardCondition';

        try {
            $inputArray = $this->decryptData($request->requestData);

            $user_id         = $inputArray['user_id'];
            $role            = $inputArray['role'] ?? null;
            $designation     = $inputArray['designation'] ?? null;
            $course_catagory = $inputArray['course_catagory'] ?? null;
            $metric          = $inputArray['metric'] ?? 'points';

            // ✅ Pre-calc total hours per user
            $metric_hours = DB::table('cpt_points_hours_calculate')
                ->select('user_id', DB::raw('SUM(hours) as total_hours'))
                ->groupBy('user_id')
                ->pluck('total_hours', 'user_id');

            // Course filter → get userIds
            $userIds = null;
            if (!empty($course_catagory)) {
                $course = DB::table('elearning_courses')
                    ->where('course_id', $course_catagory)
                    ->select('user_ids')
                    ->first();

                $userIds = $course && !empty($course->user_ids)
                    ? array_map('intval', explode(',', $course->user_ids))
                    : [];
            }

            // Main query (always fetch points)
            $query = DB::table('users')
                ->leftJoin('user_cpt_points', 'users.id', '=', 'user_cpt_points.user_id')
                ->select(
                    'users.id',
                    'users.name',
                    'users.profile_image',
                    DB::raw('SUM(user_cpt_points.cpt_points) as total_points')
                )
                ->groupBy('users.id', 'users.name', 'users.profile_image');

            // Apply filters
            if (!empty($role)) {
                $query->where('users.role_id', $role);
            }
            if (!empty($designation)) {
                $query->where('users.designation_id', $designation);
            }
            if ($userIds !== null) {
                $query->whereIn('users.id', $userIds);
            }

            // Raw leaderboard
            $leaderboard = $query->get();

            // Merge hours + dynamic metric
            foreach ($leaderboard as $user) {
                $user->total_hours = $metric_hours[$user->id] ?? 0;
                $user->total_metric = ($metric === 'hours')
                    ? $user->total_hours
                    : $user->total_points;
            }

            // ✅ Sort by chosen metric
            if ($metric === 'hours') {
                // Ascending order for hours
                $leaderboard = $leaderboard->sortBy('total_metric')->values();
            } else {
                // Descending order for points
                $leaderboard = $leaderboard->sortByDesc('total_metric')->values();
            }

            // Levels
            $levels = DB::table('gamification_levels')->orderBy('min_point')->get();
            $default_level_icon = $levels->first()->level_icon ?? null;

            foreach ($leaderboard as $user) {
                $level = $levels->first(function ($lvl) use ($user) {
                    return $lvl->min_point <= $user->total_points && $lvl->max_point >= $user->total_points;
                });

                $user->level_name = $level->level_name ?? 'N/A';
                $user->level_icon = $level->level_icon ?? $default_level_icon;
            }

            // Rewards (group by user_id)
            $rewardsGrouped = DB::table('user_course_rewards_strikes')
                ->select('reward_type', 'reward_name', 'icon', 'user_id')
                ->orderBy('id', 'desc')
                ->get()
                ->groupBy('user_id');

            // Enrich leaderboard with badges & streaks
            $enrichedLeaderboard = $leaderboard->transform(function ($user) use ($rewardsGrouped) {
                $userRewards = $rewardsGrouped->get($user->id, collect());
                $user->badges  = $userRewards->where('reward_type', 'badge')->values();
                $user->streaks = $userRewards->where('reward_type', 'streak')->values();
                return $user;
            });

            // Current user rank
            $currentUserRank = null;
            foreach ($enrichedLeaderboard as $rank => $u) {
                if ($u->id == $user_id) {
                    $currentUserRank = [
                        'rank'          => $rank + 1,
                        'name'          => $u->name,
                        'points'        => $u->total_points,
                        'total_hours'   => $u->total_hours,
                        'profile_image' => $u->profile_image,
                        'level_name'    => $u->level_name,
                        'level_icon'    => $u->level_icon,
                    ];
                    break;
                }
            }

            // Filter message
            $filterMessageText = "Showing Overall Leaderboard";
            $appliedFilters = [];

            if (!empty($course_catagory)) {
                $courseName = DB::table('elearning_courses')
                    ->where('course_id', $course_catagory)
                    ->value('course_name');
                if ($courseName) {
                    $appliedFilters[] = "Course By : {$courseName}";
                }
            }

            if (!empty($role)) {
                $roleName = DB::table('uam_roles')
                    ->where('role_id', $role)
                    ->value('role_name');
                if ($roleName) {
                    $appliedFilters[] = "Role By : {$roleName}";
                }
            }

            if (!empty($designation)) {
                $designationName = DB::table('designation')
                    ->where('designation_id', $designation)
                    ->value('designation_name');
                if ($designationName) {
                    $appliedFilters[] = "Designation By : {$designationName}";
                }
            }

            if (count($appliedFilters) > 0) {
                $filterMessageText = "Filtered by " . implode(" & ", $appliedFilters);
            }

            // ✅ Unified response
            $response = [
                'screens' => [],
                'modules' => [],
                'user_id' => $user_id,
                'rows' => [
                    'leaderboard' => [
                        'leaderboard'    => $enrichedLeaderboard,
                        'rewardsGrouped' => $rewardsGrouped,
                    ],
                    'top3'              => $enrichedLeaderboard->take(3),
                    'metric_type'       => $metric,
                    'role'              => DB::table('uam_roles')->get(),
                    'designation'       => DB::table('designation')->get(),
                    'elearning_courses' => DB::table('elearning_courses')->get(),
                    'level_icon'        => $default_level_icon,
                    'rewardsGrouped'    => $rewardsGrouped,
                    'currentUserRank'   => $currentUserRank,
                    'filterMessageText' => $filterMessageText,
                ],
                'rewardedUserId' => $user_id,
            ];

            $serviceResponse['Code']    = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data']    = $response;

            $this->WriteLog($response);

            return $this->SendServiceResponse(
                json_encode($serviceResponse, JSON_FORCE_OBJECT),
                config('setting.status_code.success'),
                true
            );
        } catch (\Exception $exc) {
            $serviceResponse['Code']    = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            return $this->SendServiceResponse(
                json_encode($serviceResponse, JSON_FORCE_OBJECT),
                config('setting.status_code.exception'),
                false
            );
        }
    }




    public function leaderboardData(Request $request)
    {
        $method = 'Method => GamificationLevelController => leaderboardData';
        try {
            $inputArray = $this->decryptData($request->requestData);

            $filter = $inputArray['filter'] ?? null;
            $metric = $inputArray['metric'] ?? 'points'; // can be "points" or "hours"
            $user_id = Auth::id();

            $role = $inputArray['role'] ?? null;
            $designation = $inputArray['designation'] ?? null;
            $course_catagory = $inputArray['course_catagory'] ?? null;

            // -------------------
            // Build base query
            // -------------------
            $query = DB::table('user_cpt_points')
                ->join('users', 'users.id', '=', 'user_cpt_points.user_id')
                ->leftJoin('cpt_points_hours_calculate', function ($join) {
                    $join->on('users.id', '=', 'cpt_points_hours_calculate.user_id')
                        ->on('user_cpt_points.course_id', '=', 'cpt_points_hours_calculate.course_id');
                })
                ->select(
                    'users.id as id',
                    'users.name',
                    'users.profile_image',
                    DB::raw('SUM(user_cpt_points.cpt_points) as total_points'),
                    DB::raw('SUM(cpt_points_hours_calculate.hours) as total_hours')
                )
                ->groupBy('users.id', 'users.name', 'users.profile_image');

            // ✅ Dynamically select metric for ranking
            if ($metric === 'hours') {
                $query->addSelect(DB::raw('SUM(cpt_points_hours_calculate.hours) as total_metric'));
            } else {
                $query->addSelect(DB::raw('SUM(user_cpt_points.cpt_points) as total_metric'));
            }

            // -------------------
            // Apply filters
            // -------------------
            if ($filter === 'WEEKLY') {
                $query->whereBetween('user_cpt_points.created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($filter === 'MONTHLY') {
                $query->whereMonth('user_cpt_points.created_at', now()->month)
                    ->whereYear('user_cpt_points.created_at', now()->year);
            }

            if (!empty($role)) {
                $query->where('users.role_id', $role);
            }
            if (!empty($designation)) {
                $query->where('users.designation_id', $designation);
            }
            if (!empty($course_catagory) && $course_catagory !== 'ALL') {
                $query->where('user_cpt_points.course_id', $course_catagory);
            }

            // Order by selected metric
            $query->orderByDesc('total_metric');

            $rows = $query->get()->values();

            // -------------------
            // Enrich with levels, badges, streaks
            // -------------------
            $levels = DB::table('gamification_levels')->orderBy('min_point')->get();
            $default_level_icon = $levels->first()->level_icon ?? null;

            $rewardsGrouped = DB::table('user_course_rewards_strikes')
                ->select('reward_type', 'reward_name', 'icon', 'user_id')
                ->orderBy('id', 'desc')
                ->get()
                ->groupBy('user_id');

            $enrichedRows = $rows->transform(function ($user) use ($levels, $default_level_icon, $rewardsGrouped) {
                $userRewards = $rewardsGrouped->get($user->id, collect());
                $user->badges  = $userRewards->where('reward_type', 'badge')->values();
                $user->streaks = $userRewards->where('reward_type', 'streak')->values();

                $level = $levels->first(function ($lvl) use ($user) {
                    return $lvl->min_point <= $user->total_points && $lvl->max_point >= $user->total_points;
                });

                $user->level_name = $level->level_name ?? 'N/A';
                $user->level_icon = $level->level_icon ?? $default_level_icon;

                return $user;
            });

            // -------------------
            // Current User Rank (based on selected metric)
            // -------------------
            $currentUserRank = null;
            foreach ($enrichedRows as $index => $u) {
                if ($u->id == $user_id) {
                    $currentUserRank = [
                        'id'     => $u->id,
                        'name'   => $u->name,
                        'points' => $u->total_points,
                        'hours'  => $u->total_hours,
                        'metric' => $u->total_metric,   // ✅ rank metric is dynamic now
                        'rank'   => $index + 1
                    ];
                    break;
                }
            }

            // -------------------
            // Final Response
            // -------------------
            $response = [
                'top3'            => $enrichedRows->take(3),
                'rankList'        => $enrichedRows->skip(3)->values(),
                'metric_type'     => $metric, // ✅ dynamic instead of hardcoded "points"
                'rewardsGrouped'  => $rewardsGrouped,
                'currentUserRank' => $currentUserRank,
            ];

            $serviceResponse['Code']    = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data']    = $response;

            return $this->SendServiceResponse(
                json_encode($serviceResponse, JSON_FORCE_OBJECT),
                config('setting.status_code.success'),
                true
            );
        } catch (\Exception $exc) {
            $serviceResponse['Code']    = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            return $this->SendServiceResponse(
                json_encode($serviceResponse, JSON_FORCE_OBJECT),
                config('setting.status_code.exception'),
                false
            );
        }
    }
}
