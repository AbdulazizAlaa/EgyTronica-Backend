<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MobilePinMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $pin = "12345";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pin)
    {
        //
        $this->pin = $pin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Mobile Verification Pin';

        return $this->view('email.mobile-pin')
                    ->subject($subject)
                    ->with('pin', $this->pin);
    }
}
