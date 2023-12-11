<?php

namespace App\Http\Controllers\Order;

use Illuminate\Routing\Controller;
use App\Http\Actions\Order\CreateOrderAction;
use App\Http\Requests\Order\CreateOrderRequest;

class CreateOrderController extends Controller
{
    /**
     * @param CreateOrderRequest $request
     * @return mixed
     */
    public function __invoke(CreateOrderRequest $request)
    {
        $data = resolve(CreateOrderAction::class)->setRequest($request)->handle();
        return $data;
    }
}
