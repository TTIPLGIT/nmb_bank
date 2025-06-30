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
}

}