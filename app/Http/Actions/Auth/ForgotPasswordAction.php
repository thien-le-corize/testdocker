<?php

namespace App\Http\Actions\Auth;

use App\Repositories\UserRepository;
use App\Http\Shared\Actions\BaseAction;
use App\Exceptions\AuthenticateException;
use App\Http\Tasks\Auth\ForgotPasswordTask;

class ForgotPasswordAction extends BaseAction
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle()
    {
        $user = $this->userRepository->getModel()->whereRaw('LOWER(email) = ?', strtolower($this->request->get('email')))->first();

        if (empty($user)) {
            throw AuthenticateException::userNotfound();
        }

        return resolve(ForgotPasswordTask::class)->handle($user, $this->request);
    }
}
