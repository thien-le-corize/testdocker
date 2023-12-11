<?php

namespace App\Http\Tasks\Auth;

use App\Models\Role;
use App\Mail\SendVerifyEmail;
use App\Jobs\SendVerifyEmailUserJob;
use App\Repositories\UserRepository;

class SendVerifyEmailTask
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle($dataUser)
    {
        $tokenVerify = $dataUser['token_verify'];
        $urlVerify = config('common.user_site_url') . '/verify-email?token='. $tokenVerify.'&email='.$dataUser['email'];

        $verifyEmail = new SendVerifyEmail($urlVerify, $dataUser['email'], $dataUser['name']);

        SendVerifyEmailUserJob::dispatch(
            $dataUser['email'],
            $dataUser['name'],
            $verifyEmail
        );

        return [
            'messages' => 'Sending mail.'
        ];

    }
}
