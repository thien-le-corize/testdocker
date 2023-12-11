<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use App\Http\Actions\Auth\RegisterAction;
use App\Http\Requests\Auth\RegisterRequest;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        $data = resolve(RegisterAction::class)->setRequest($request)->handle();
        return $data;
    }
}
