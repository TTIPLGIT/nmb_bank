<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class nruregistrarrejectMail extends Mailable
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

         $email_id = config('setting.email_id');

        return $this->from($email_id)->subject('NRU Application Rejection Notification')->view('email.nruregistrarrejectmail')->with('data',$this->data);
    }

}
