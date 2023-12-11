<?php

namespace App\Http\Controllers\Order;

use Illuminate\Routing\Controller;
use App\Http\Actions\Order\PrintOrderAction;
use App\Http\Requests\Order\PrintOrderRequest;

class PrintOrderController extends Controller
{
    /**
     * @param PrintOrderRequest $request
     * @return mixed
     */
    public function __invoke(PrintOrderRequest $request, $orderCode)
    {
        $data = resolve(PrintOrderAction::class)->setParams(['orderCode' => $orderCode])->handle();
        return $data;
    }
}
