<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MeetingStatusUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $meeting;
    public $status;
    public $notes;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($meeting, $status, $notes)
    {
        $this->meeting = $meeting;
        $this->status = $status;
        $this->notes = $notes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Meeting Status Update: ' . ucfirst($this->status);
        
        return $this->subject($subject)
                    ->view('email.meeting_status_update')
                    ->with([
                        'meeting' => $this->meeting,
                        'status' => $this->status,
                        'notes' => $this->notes
                    ]);
    }
}