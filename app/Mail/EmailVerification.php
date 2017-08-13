<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use URL;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $token = "hello";
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        //
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Verify your email';

        $link = URL::to('/').'/api/email/'.$this->token;

        return $this->view('email.email-verification')
                    ->subject($subject)
                    ->with('link', $link);
    }
}
