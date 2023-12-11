<?php

namespace App\Http\Controllers\Order;

use Illuminate\Routing\Controller;
use App\Http\Actions\Order\DetailOrderAction;
use App\Http\Requests\Order\DetailOrderRequest;
use App\Http\Resources\Order\OrderProductCollection;

class DetailOrderController extends Controller
{
    /**
     * @param DetailOrderRequest $request
     * @return mixed
     */
    public function __invoke(DetailOrderRequest $request, $orderID)
    {
        $data = resolve(DetailOrderAction::class)
            ->setRequest($request)
            ->setParams(['orderID' => $orderID])
            ->handle();
        return $data;
        // return (new OrderProductCollection($data));
    }
}
