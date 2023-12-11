<?php

namespace App\Http\Controllers\Order;

use Illuminate\Routing\Controller;
use App\Http\Actions\Order\GetUrlPaymentAction;
use App\Http\Requests\Order\GetUrlPaymentRequest;

class GetUrlPaymentController extends Controller
{
    /**
     * @param GetUrlPaymentRequest $request
     * @return mixed
     */
    public function __invoke(GetUrlPaymentRequest $request)
    {
        $data = resolve(GetUrlPaymentAction::class)->setRequest($request)->handle();
        return $data;
    }
}
