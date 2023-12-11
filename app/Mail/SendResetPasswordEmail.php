<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    protected $name;
    protected $redirectUrl;
    protected $expiredTime;

    public function __construct($email, $name, $redirectUrl, $expiredTime)
    {
        $this->email = $email;
        $this->name = $name;
        $this->redirectUrl = $redirectUrl;
        $this->expiredTime = $expiredTime;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Reset Password';
        return  $this->subject($subject)
        ->view('emails.reset_password')
        ->with([
            'email' => $this->email,
            'name' => $this->name,
            'urlResetPassword' => $this->redirectUrl,
            'expiredTime' => $this->expiredTime,
        ]);
    }


}
