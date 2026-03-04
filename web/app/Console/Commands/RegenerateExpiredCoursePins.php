<?php

namespace App\Console\Commands;

use App\Mail\regenerateMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RegenerateExpiredCoursePins extends Command
{
    protected $signature = 'course:regenerate-pin';
    protected $description = 'Automatically regenerate course PIN after 24 hours';

    public function handle()
    {
        $expiredCourses = DB::table('elearning_courses')
            ->whereNotNull('course_pin_created_at')
            ->where('course_pin_created_at', '<=', now()->subHours(24))
            ->get();

        foreach ($expiredCourses as $course) {
            // 🔹 Generate new PIN
            $newPin = rand(100000, 999999);

            DB::table('elearning_courses')
                ->where('course_id', $course->course_id)
                ->update([
                    'course_pin' => $newPin,
                    'course_pin_created_at' => now()
                ]);

            // 🔹 Get users for this course
            if (empty($course->user_ids)) {
                continue;
            }

            $userIds = explode(',', $course->user_ids);

            $users = DB::table('users')
                ->whereIn('id', $userIds)
                ->select('id', 'email', 'name')
                ->get();

            foreach ($users as $user) {

                // ✅ Log


                // ✅ Send Mail
                Mail::to($user->email)->queue(
                    new regenerateMail([
                        'name' => $user->name,
                        'course_pin' => $newPin,
                        'course_name' => $course->course_name
                    ])
                );
            }

            // ✅ Audit Log (use SYSTEM user)

        }

        $this->info('Expired course PINs regenerated and emails sent successfully.');
    }
}
