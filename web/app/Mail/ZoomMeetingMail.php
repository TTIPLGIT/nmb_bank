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
        // Check if email configuration exists
        $fromEmail = config('setting.email_id');
        
        if (!$fromEmail) {
            \Log::error('Email configuration missing: setting.email_id is not set');
        }
        
        return $this
            ->from($fromEmail, config('app.name', 'LMS System'))
            ->subject('Meeting Invitation: ' . ($this->meeting->topic ?? 'New Meeting'))
            ->view('email.ZoomMeetingMail');
    }
}