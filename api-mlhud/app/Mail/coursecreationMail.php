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
       

        return $this->from(config('setting.email_id'))
            ->subject('Course Enrollment')
            ->view('email.coursecreationmail')
            ->with($this->data);
    }
}