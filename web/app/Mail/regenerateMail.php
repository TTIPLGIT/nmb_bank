<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use DateTime;
use Illuminate\Support\Facades\Mail;

class regenerateMail extends Mailable
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

    


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('setting.email_id'))
            ->subject('Course Regenerate PIN')
            ->view('email.coursecreationmail')
            ->with([
                'name' => $this->data['name'],
                'course_name' => $this->data['course_name'],
                'course_pin' => $this->data['course_pin']
            ]);
    }
}
