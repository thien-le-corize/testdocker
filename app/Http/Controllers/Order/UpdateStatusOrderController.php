<?php

namespace App\Http\Controllers\Order;

use Illuminate\Routing\Controller;
use App\Http\Actions\Order\UpdateStatusOrderAction;
use App\Http\Requests\Order\UpdateStatusOrderRequest;

class UpdateStatusOrderController extends Controller
{
    /**
     * @param UpdateStatusOrderRequest $request
     * @return mixed
     */
    public function __invoke(UpdateStatusOrderRequest $request)
    {
        $data = resolve(UpdateStatusOrderAction::class)->setRequest($request)->handle();
        return $data;
    }
}
