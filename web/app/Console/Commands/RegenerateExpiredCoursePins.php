<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Mail\coursecreationmail;
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
                ->where('id', $course->id)
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
                $this->WriteFileLog(
                    "Sending PIN {$newPin} for course {$course->course_name} to {$user->email}",
                    'COURSE_PIN_CRON'
                );

                // ✅ Send Mail
                Mail::to($user->email)->send(
                    new coursecreationmail([
                        'name'        => $user->name,
                        'course_pin'  => $newPin,
                        'course_name' => $course->course_name,
                    ])
                );
            }

            // ✅ Audit Log (use SYSTEM user)
            $this->auditLog(
                'elearning_courses',
                $course->id,
                'Updated',
                'Course PIN auto-regenerated after 24 hours',
                0, // system user
                now(),
                'SYSTEM'
            );
        }

        $this->info('Expired course PINs regenerated and emails sent successfully.');
    }
}
