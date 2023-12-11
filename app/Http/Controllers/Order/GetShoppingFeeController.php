<?php

namespace App\Http\Controllers\Order;

use Illuminate\Routing\Controller;
use App\Http\Actions\Order\GetShoppingFeeAction;
use App\Http\Requests\Order\GetShoppingFeeRequest;

class GetShoppingFeeController extends Controller
{
    /**
     * @param GetShoppingFeeRequest $request
     * @return mixed
     */
    public function __invoke(GetShoppingFeeRequest $request)
    {
        $data = resolve(GetShoppingFeeAction::class)->setRequest($request)->handle();
        return $data;
    }
}
