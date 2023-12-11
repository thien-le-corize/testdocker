<?php

namespace App\Http\Actions\Auth;

use App\Http\Tasks\Auth\RegisterTask;
use App\Http\Shared\Actions\BaseAction;

class RegisterAction extends BaseAction
{
    /**
     * handle
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function handle()
    {
        return resolve(RegisterTask::class)->handle($this->request);
    }
}
