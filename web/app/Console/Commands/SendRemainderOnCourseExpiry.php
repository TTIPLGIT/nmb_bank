<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

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

        foreach ($targetUserIds as $userId) {
            $message = '';
            $status = '';

            if ($daysDiff <= 15 && $daysDiff >= 0) {
                $message = "Your certificate for {$row->course_name}  Course ID is expiring in {$daysDiff} day(s). Please re-enroll.";
                $status = 'Certificate Expiry Reminder';
            } elseif ($daysDiff < 0) {
                $message = "Your certificate for {$row->course_name}  Course ID has expired. Please re-enroll.";
                $status = 'Certificate Expired';
            }

            if ($message !== '') {
                DB::table('notifications')->insert([
                    'user_id' => $userId,
                    'notification_status' => $status,
                    'notification_type' => 'Certificate Expire',
                    'notification_url' => '/elearning/allCourses',
                    'megcontent' => $message,
                    'alert_meg' => $message,
                    'created_by' => 1, 
                    'created_at' => now()
                ]);
            }
        }
    }

    \Log::info('Certificate expiry & expired notifications sent.');

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
        ->select('ucr.user_id', 'ucr.complete_in_day', 'ucr.complete_in_hours', 'ucr.course_id')
        ->get()
        ->groupBy('user_id');

    // Allowed time for streak calculation (no conversion now)
    $allowedTime = 0;
    $timeUnit = $category->complete_within_type;

    if ($timeUnit === 'day') {
        $allowedTime = (int) $category->complete_within;
    } elseif ($timeUnit === 'hours') {
        $allowedTime = (int) $category->complete_within;
    }

    foreach ($userCourses as $userId => $courses) {
        $totalCompleted = count($courses);
        $completedInTime = 0;

        foreach ($courses as $course) {
            $userTime = 0;

            if ($timeUnit === 'day') {
                $userTime = (float) $course->complete_in_day;
            } elseif ($timeUnit === 'hours') {
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