<?php

namespace App\Http\Controllers\Order;

use Illuminate\Routing\Controller;
use App\Http\Actions\Order\ReturnUrlAction  ;
use App\Http\Requests\Order\ReturnUrlRequest;

class ReturnUrlController extends Controller
{
    /**
     * @param ReturnUrlRequest $request
     * @return mixed
     */
    public function __invoke(ReturnUrlRequest $request)
    {
        $data = resolve(ReturnUrlAction ::class)->setRequest($request)->handle();
        return $data;
    }
}
