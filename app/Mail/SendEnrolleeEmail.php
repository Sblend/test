<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEnrolleeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user_d;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_d)
    {
        $this->data = $user_d;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('emails.welcome', ['user'=>$this->data])->subject('Welcome Onboard')->from('hygeia@careclick.healthcare','HygeiaHMO');
        
    }
}
