<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;

class SendRemainderOnCourseExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
   protected $signature = 'course:send-expiry-reminder';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
public function handle()
{
    $today = \Carbon\Carbon::today();

    $listof_expire = DB::table('elearning_courses AS e')
        ->select(
            'e.course_id',
            'ucr.user_id',
            'e.role_id',
            'e.designation_id',
            'e.user_ids',
            'e.course_expiry_period','e.course_name'
        )
        ->join(
            'user_course_relation as ucr',
            'e.course_id',
            '=',
            'ucr.course_id'
        )
        ->where('ucr.course_status', 'Completed')
        ->where('e.certificate_expiry', '1')
        ->get();

    foreach ($listof_expire as $row) {
        $expiryDate = \Carbon\Carbon::parse($row->course_expiry_period);
        $daysDiff = $today->diffInDays($expiryDate, false);

        // 📋 Determine user targets
        $targetUserIds = [];

        if (!empty($row->user_ids)) {
            $targetUserIds = explode(',', $row->user_ids);
        } elseif ($row->user_id != 0) {
            $targetUserIds = [$row->user_id];
        } else {
            // 🔍 user_id = 0 => get all users by role and designation
            $query = DB::table('users')->select('id');

            if (!is_null($row->role_id)) {
                $query->where('role_id', $row->role_id);
            }
            if (!is_null($row->designation_id)) {
                $query->where('designation_id', $row->designation_id);
            }

            $targetUserIds = $query->pluck('id')->toArray();
        }

        // foreach ($targetUserIds as $userId) {
        //     $message = '';
        //     $status = '';

        //     if ($daysDiff <= 15 && $daysDiff >= 0) {
        //         $message = "Your certificate for {$row->course_name}  Course ID is expiring in {$daysDiff} day(s). Please re-enroll.";
        //         $status = 'Certificate Expiry Reminder';
        //     } elseif ($daysDiff < 0) {
        //         $message = "Your certificate for {$row->course_name}  Course ID has expired. Please re-enroll.";
        //         $status = 'Certificate Expired';
        //     }

        //     if ($message !== '') {
        //         DB::table('notifications')->insert([
        //             'user_id' => $userId,
        //             'notification_status' => $status,
        //             'notification_type' => 'Certificate Expire',
        //             'notification_url' => '/elearning/allCourses?sorted=Recently%20Added&tag=false&progress=false&q=false',
        //             'megcontent' => $message,
        //             'alert_meg' => $message,
        //             'created_by' => 1, 
        //             'created_at' => now()
        //         ]);
        //     }
        // }
    }

    // \Log::info('Certificate expiry & expired notifications sent.');

$categories = DB::table('course_catagory')
    ->where(function ($q) {
        $q->where('badge', 1)
          ->orWhere('streak_challenge', 1);
    })
    ->get();

foreach ($categories as $category) {
    $userCourses = DB::table('user_course_relation as ucr')
        ->join('elearning_courses as ec', 'ec.course_id', '=', 'ucr.course_id')
        ->where('ucr.course_status', 'Completed')
        ->where('ec.course_category', $category->catagory_id)
        ->select(
            'ucr.user_id', 
            'ucr.course_id',
            'ucr.course_enroll_date as course_start_date',
            'ucr.course_completion_date as course_completion_date',
        )
        ->get()
        ->filter(function($course) {
            // Only include courses with valid completion dates
            return !is_null($course->course_completion_date);
        })
        ->map(function($course) {
            $startDate = Carbon::parse($course->course_start_date);
            $completionDate = Carbon::parse($course->course_completion_date);
            
            // Handle case where completion date is earlier than start date
            if ($completionDate->lt($startDate)) {
                // Swap them or set to minimum
                $temp = $startDate;
                $startDate = $completionDate;
                $completionDate = $temp;
            }
            
            // Calculate exact differences
            $diffInSeconds = $startDate->diffInSeconds($completionDate);
            $diffInMinutes = $startDate->diffInMinutes($completionDate);
            $diffInHours = $startDate->diffInHours($completionDate);
            $diffInDays = $startDate->diffInDays($completionDate);
            
            // Calculate remaining hours and minutes
            $remainingHours = $diffInHours % 24;
            $remainingMinutes = $diffInMinutes % 60;
            
            // Calculate exact days with decimal (for partial days)
            $exactDays = $diffInSeconds / 86400; // 86400 seconds in a day
            $exactHours = $diffInSeconds / 3600; // 3600 seconds in an hour
            
            $course->complete_in_seconds = $diffInSeconds;
            $course->complete_in_minutes = $diffInMinutes;
            $course->complete_in_hours = $diffInHours;
            $course->complete_in_days = $diffInDays;
            $course->remaining_hours = $remainingHours;
            $course->remaining_minutes = $remainingMinutes;
            $course->exact_days = $exactDays;
            $course->exact_hours = $exactHours;
            
            // Format for display
            if ($diffInDays > 0) {
                $course->formatted_time = $diffInDays . ' days, ' . $remainingHours . ' hours, ' . $remainingMinutes . ' minutes';
            } elseif ($diffInHours > 0) {
                $course->formatted_time = $diffInHours . ' hours, ' . $remainingMinutes . ' minutes';
            } else {
                $course->formatted_time = $diffInMinutes . ' minutes';
            }
            
            return $course;
        })
        ->groupBy('user_id');

    // Get allowed time configuration
    $allowedTime = 0;
    $timeUnit = $category->complete_within_type;
    
    if ($timeUnit === 'Day') {
        $allowedTime = (int) $category->complete_within;
    } elseif ($timeUnit === 'time') {
        $allowedTime = (int) $category->complete_within;
    }

    foreach ($userCourses as $userId => $courses) {
        $totalCompleted = count($courses);
        $completedInTime = 0;
        
        // Detailed tracking for debugging
        $courseDetails = [];

        foreach ($courses as $course) {
            $isInTime = false;
            $userTimeValue = 0;
            $userTimeUnit = '';
            
            if ($timeUnit === 'Day') {
                // For day comparison: even 23 hours counts as 0 days, but we need to check if it's within allowed days
                // Example: If allowed is 1 day, then 23 hours (0.96 days) should count as within time
                if ($course->exact_days <= $allowedTime) {
                    $isInTime = true;
                    $userTimeValue = $course->exact_days;
                    $userTimeUnit = 'days';
                }
                // Also check if within hours if days is 0 but hours less than 24
                elseif ($course->complete_in_days == 0 && $course->complete_in_hours < 24 && $allowedTime >= 1) {
                    $isInTime = true;
                    $userTimeValue = $course->exact_days;
                    $userTimeUnit = 'days';
                }
                
            } elseif ($timeUnit === 'time') {
                // For hour comparison: convert everything to hours including minutes
                // Example: 1 hour 30 minutes = 1.5 hours
                $totalHoursDecimal = $course->complete_in_hours + ($course->remaining_minutes / 60);
                
                if ($totalHoursDecimal <= $allowedTime) {
                    $isInTime = true;
                    $userTimeValue = $totalHoursDecimal;
                    $userTimeUnit = 'hours';
                }
                // Also check if days need to be converted to hours
                elseif ($course->complete_in_days > 0) {
                    $totalHoursFromDays = ($course->complete_in_days * 24) + $course->complete_in_hours + ($course->remaining_minutes / 60);
                    if ($totalHoursFromDays <= $allowedTime) {
                        $isInTime = true;
                        $userTimeValue = $totalHoursFromDays;
                        $userTimeUnit = 'hours';
                    }
                }
            }
            
            if ($isInTime) {
                $completedInTime++;
            }
            
            // Store course details for debugging
            $courseDetails[] = [
                'course_id' => $course->course_id,
                'start_date' => $course->course_start_date,
                'completion_date' => $course->course_completion_date,
                'total_days' => $course->complete_in_days,
                'total_hours' => $course->complete_in_hours,
                'total_minutes' => $course->complete_in_minutes,
                'exact_days' => round($course->exact_days, 2),
                'exact_hours' => round($course->exact_hours, 2),
                'within_time' => $isInTime,
                'allowed_time' => $allowedTime,
                'time_unit' => $timeUnit
            ];
        }
        
        // Log for debugging
        \Log::info('Category: ' . $category->catagory_name, [
            'user_id' => $userId,
            'total_completed' => $totalCompleted,
            'completed_in_time' => $completedInTime,
            'required_for_streak' => $category->number_course_for_streak,
            'course_details' => $courseDetails
        ]);

        // Badge logic
        if (
            $category->badge == 1 &&
            $totalCompleted >= $category->badge_count &&
            !DB::table('user_course_rewards_strikes')->where([
                ['user_id', '=', $userId],
                ['category_id', '=', $category->catagory_id],
                ['reward_type', '=', 'badge']
            ])->exists()
        ) {
            DB::table('user_course_rewards_strikes')->insert([
                'user_id' => $userId,
                'category_id' => $category->catagory_id,
                'reward_type' => 'badge',
                'reward_name' => $category->badge_name,
                'icon' => $category->badge_icon,
                'points' => 0,
                'awarded_at' => now()
            ]);
            
            \Log::info('Badge awarded', [
                'user_id' => $userId,
                'category' => $category->catagory_name,
                'badge_name' => $category->badge_name
            ]);
        }

        // Streak logic - must complete required number of courses within allowed time
        if (
            $category->streak_challenge == 1 &&
            $totalCompleted >= $category->number_course_for_streak &&
            $completedInTime >= $category->number_course_for_streak &&
            !DB::table('user_course_rewards_strikes')->where([
                ['user_id', '=', $userId],
                ['category_id', '=', $category->catagory_id],
                ['reward_type', '=', 'streak']
            ])->exists()
        ) {
            // Add CPT points
            DB::table('user_cpt_points')->insert([
                'user_id' => $userId,
                'course_id' => 0,
                'cpt_points' => $category->bonus_point,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            // Update user total CPT points
            DB::table('users')
                ->where('id', $userId)
                ->update([
                    'total_cptpoints' => DB::raw("total_cptpoints + {$category->bonus_point}")
                ]);
            
            // Insert streak reward
            DB::table('user_course_rewards_strikes')->insert([
                'user_id' => $userId,
                'category_id' => $category->catagory_id,
                'reward_type' => 'streak',
                'reward_name' => $category->streak_name,
                'icon' => $category->streak_icon,
                'points' => $category->bonus_point ?? 0,
                'awarded_at' => now()
            ]);
            
            \Log::info('Streak awarded', [
                'user_id' => $userId,
                'category' => $category->catagory_name,
                'bonus_points' => $category->bonus_point,
                'courses_completed' => $totalCompleted,
                'completed_in_time' => $completedInTime
            ]);
        }
    }
}foreach ($categories as $category) {
  $userCourses = DB::table('user_course_relation as ucr')
    ->join('elearning_courses as ec', 'ec.course_id', '=', 'ucr.course_id')
    ->where('ucr.course_status', 'Completed')
    ->where('ec.course_category', $category->catagory_id)
    ->select(
        'ucr.user_id', 
        'ucr.course_id',
        'ucr.course_enroll_date as course_start_date',  // When user started the course
        'ucr.course_completion_date as course_completion_date', // When user completed
        
    )
    ->get()
    ->map(function($course) {
        // Calculate from user's actual start and completion dates
        $startDate = Carbon::parse($course->course_start_date);
        $completionDate = Carbon::parse($course->course_completion_date);
        
        // Calculate difference
        $diffInDays = $startDate->diffInDays($completionDate);
        $diffInHours = $startDate->diffInHours($completionDate);
        
        // Format as days and hours
        $remainingHours = $diffInHours % 24;
        
        $course->complete_in_day = $diffInDays;
        $course->complete_in_hours = $remainingHours;
        $course->total_hours = $diffInHours;
        
        return $course;
    })
    ->groupBy('user_id');

    // Allowed time for streak calculation (no conversion now)
    $allowedTime = 0;
    $timeUnit = $category->complete_within_type;

    if ($timeUnit === 'Day') {
        $allowedTime = (int) $category->complete_within;
    } elseif ($timeUnit === 'time') {
        $allowedTime = (int) $category->complete_within;
    }

    foreach ($userCourses as $userId => $courses) {
        $totalCompleted = count($courses);
        $completedInTime = 0;

        foreach ($courses as $course) {
            $userTime = 0;

            if ($timeUnit === 'Day') {
                $userTime = (float) $course->complete_in_day;
            } elseif ($timeUnit === 'time') {
                $userTime = (float) $course->complete_in_hours;
            }

            if ($userTime > 0 && $userTime <= $allowedTime) {
                $completedInTime++;
            }
        }

        // ✅ Badge logic
        if (
            $category->badge == 1 &&
            $totalCompleted >= $category->badge_count &&
            !DB::table('user_course_rewards_strikes')->where([
                ['user_id', '=', $userId],
                ['category_id', '=', $category->catagory_id],
                ['reward_type', '=', 'badge']
            ])->exists()
        ) {
            DB::table('user_course_rewards_strikes')->insert([
                'user_id' => $userId,
                'category_id' => $category->catagory_id,
                'reward_type' => 'badge',
                'reward_name' => $category->badge_name,
                'icon' => $category->badge_icon,
                'points' => 0,
                'awarded_at' => now()
            ]);
        }

        // ✅ Streak logic (must meet both count & time)
        if (
            $category->streak_challenge == 1 &&
            $totalCompleted >= $category->number_course_for_streak &&
            $completedInTime >= $category->number_course_for_streak &&
            !DB::table('user_course_rewards_strikes')->where([
                ['user_id', '=', $userId],
                ['category_id', '=', $category->catagory_id],
                ['reward_type', '=', 'streak']
            ])->exists()
        ) {

             DB::table('user_cpt_points')->insert([
                'user_id' => $userId,
                'course_id' => 0,
                'cpt_points' => $category->bonus_point
            ]);
           DB::table('users')
            ->where('id', $userId)
            ->update([
                'total_cptpoints' => DB::raw("total_cptpoints + {$category->bonus_point}")
            ]);


          
            DB::table('user_course_rewards_strikes')->insert([
                'user_id' => $userId,
                'category_id' => $category->catagory_id,
                'reward_type' => 'streak',
                'reward_name' => $category->streak_name,
                'icon' => $category->streak_icon,
                'points' => $category->bonus_point ?? 0,
                'awarded_at' => now()
            ]);


           
            
        }

        // ❌ Optional Strike (uncomment if needed)
        /*
        if (
            $category->streak_challenge == 1 &&
            $totalCompleted >= $category->number_course_for_streak &&
            $completedInTime < $category->number_course_for_streak &&
            !DB::table('user_course_rewards_strikes')->where([
                ['user_id', '=', $userId],
                ['course_id', '=', $category->catagory_id],
                ['reward_type', '=', 'strike']
            ])->exists()
        ) {
            DB::table('user_course_rewards_strikes')->insert([
                'user_id' => $userId,
                'course_id' => $category->catagory_id,
                'reward_type' => 'strike',
                'reward_name' => $category->streak_name,
                'icon' => $category->streak_icon,
                'points' => 0,
                'awarded_at' => now()
            ]);
        }
        */
    }
}

\Log::info('✅ Badge & Streak logic executed based on actual time units without conversion.');


}

}