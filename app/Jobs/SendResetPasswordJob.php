<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendResetPasswordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

const TIME_FORMAT = 'Y-m-d H:i:s';
    const TIME_DELAY = 10;
    protected $email;
    protected $name;
    protected $redirectUrl;
    protected $expiredTime;
    protected $mailable;
    protected $fetchMailAction;
    protected $startTime;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        string $email,
        string $name,
        string $redirectUrl,
        string $expiredTime,
        Mailable $mailable,
        $startTime = null
    )
    {
        $this->email = $email;
        $this->name = $name;
        $this->redirectUrl = $redirectUrl;
        $this->expiredTime = $expiredTime;
        $this->mailable = $mailable;
        $this->startTime = $startTime ?? date(self::TIME_FORMAT);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('Start send email | email: ' . $this->email);
        $this->sendEmail($this->email, $this->mailable);
        Log::info('End send email | email: ' . $this->email);
    }

    /**
     * @param string $email
     * @param Mailable $mailable
     * @return bool
     */
    protected function sendEmail($email, $mailable)
    {
        try {
            Mail::to($email)->send($mailable);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
