<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use DateTime;

class coursecreationmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function date_difference($dateFromDB)
    {
        $today = new DateTime();


        $datetime2 = new DateTime($dateFromDB); // Date from the database
        $interval = $datetime2->diff($today);


        $days = $interval->format('%d');


        return $days;
    }



    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $courses = DB::select("select * from elearning_courses where drop_course=0");
        foreach ($courses as $key => $row) {
            # code...
            $date_difference = coursecreationmail::date_difference($row->course_start_period);
            if ($date_difference == 2) {
                $role_id = $row['user'];
                $where = $row['user'] != 0 ? "AND uam_user_roles.role_id =$role_id" : "";
                $users = DB::select("select * from users where active_flag=0" . $where);
                foreach ($users as $key => $user) {
                    # code...
                    $email_id = config('setting.email_id');

                    return $this->from($email_id)->subject('New Courses Available')->view('email.coursecreationmail')->with('data', $this->data);
                }
            }
        }
    }
}
