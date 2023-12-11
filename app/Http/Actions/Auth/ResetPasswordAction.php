<?php

namespace App\Http\Actions\Auth;

use App\Http\Shared\Actions\BaseAction;
use App\Http\Tasks\Auth\ResetPasswordTask;

class ResetPasswordAction extends BaseAction
{
    public function handle()
    {
        return resolve(ResetPasswordTask::class)->handle($this->request);
    }
}
