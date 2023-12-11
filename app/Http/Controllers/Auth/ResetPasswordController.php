<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use App\Http\Actions\Auth\ResetPasswordAction;
use App\Http\Requests\Auth\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    /**
     * @param ResetPasswordRequest $request
     * @return mixed
     */
    public function __invoke(ResetPasswordRequest $request)
    {
        $data = resolve(ResetPasswordAction::class)->setRequest($request)->handle();
        return $data;
    }
}
