<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use App\Http\Actions\Auth\ChangePasswordAction;
use App\Http\Requests\Auth\ChangePasswordRequest;

class ChangePasswordController extends Controller
{
    /**
     * @param ChangePasswordRequest $request
     * @return mixed
     */
    public function __invoke(ChangePasswordRequest $request)
    {
        $data = resolve(ChangePasswordAction::class)->setRequest($request)->handle();
        return $data;
    }
}
