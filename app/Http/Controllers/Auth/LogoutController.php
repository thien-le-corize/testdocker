<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{

    public function __invoke()
    {
        auth()->logout();

        $response = ['message' => ' logout successfully'];

        return $response;
    }
}
