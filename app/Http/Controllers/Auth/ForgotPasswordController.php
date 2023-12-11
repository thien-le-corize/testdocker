<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use App\Http\Actions\Auth\ForgotPasswordAction;
use App\Http\Requests\Auth\ForgotPasswordRequest;

class ForgotPasswordController extends Controller
{
    /**
     * @param ForgotPasswordRequest $request
     * @return mixed
     */
    public function __invoke(ForgotPasswordRequest $request)
    {
        $data = resolve(ForgotPasswordAction::class)->setRequest($request)->handle();
        return $data;
    }
}
