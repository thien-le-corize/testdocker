<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use App\Http\Actions\Auth\VerifyEmailAction;
use App\Http\Requests\Auth\VerifyEmailRequest;

class VerifyEmailController extends Controller
{
    public function __invoke(VerifyEmailRequest $request)
    {
        $data = resolve(VerifyEmailAction::class)->setRequest($request)->handle();
        return $data;
    }
}
