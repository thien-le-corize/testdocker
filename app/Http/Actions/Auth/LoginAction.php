<?php

namespace App\Http\Actions\Auth;

use App\Http\Tasks\Auth\LoginTask;
use App\Http\Shared\Actions\BaseAction;

class LoginAction extends BaseAction
{
    /**
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public function handle()
    {
        return resolve(LoginTask::class)->handle($this->request);
    }
}
