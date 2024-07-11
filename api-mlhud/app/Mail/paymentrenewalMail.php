<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;


class paymentrenewalMail extends Mailable
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
        $data = $this->data;

         $email_id = config('setting.email_id');
      

        return $this->from($email_id)->subject('Payment Renewal Confirmation On Licence ')->view('email.paymentrenewalmail')->with('data',$this->data);
    }

}
