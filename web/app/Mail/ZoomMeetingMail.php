<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ZoomMeetingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $meeting;

    public function __construct($meeting)
    {
        $this->meeting = $meeting;
    }

    public function build()
    {
        return $this->subject('Zoom Meeting Invitation')
            ->view('email.ZoomMeetingMail')
            ->with([
                'meeting' => $this->meeting
            ]);
    }
}
