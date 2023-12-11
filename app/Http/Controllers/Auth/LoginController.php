<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use App\Http\Actions\Auth\LoginAction;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return mixed
     */
    public function __invoke(LoginRequest $request)
    {
        $data = resolve(LoginAction::class)->setRequest($request)->handle();
        return $data;
    }
}
