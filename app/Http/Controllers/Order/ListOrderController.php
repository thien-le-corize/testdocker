<?php

namespace App\Http\Controllers\Order;

use Illuminate\Routing\Controller;
use App\Http\Actions\Order\ListOrderAction;
use App\Http\Requests\Order\ListOrderRequest;
use App\Http\Resources\Order\OrderCollection;

class ListOrderController extends Controller
{
    /**
     * @param ListOrderRequest $request
     * @return mixed
     */
    public function __invoke(ListOrderRequest $request)
    {
        $data = resolve(ListOrderAction::class)->setRequest($request)->handle();
        return (new OrderCollection($data));
    }
}
