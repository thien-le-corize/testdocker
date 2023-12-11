<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendVerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $urlVerify;
    protected $email;
    protected $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($urlVerify, $email, $name)
    {
        $this->urlVerify = $urlVerify;
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Verify Your Email Address';

        return  $this->subject($subject)
        ->view('emails.verify_email')
        ->with([
            'urlVerify' =>  $this->urlVerify,
            'email' => $this->email,
            'name' => $this->name,
        ]);
    }
}
