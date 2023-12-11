<?php

namespace App\Http\Controllers\ShopeeVoucher;

use App\Http\Actions\ShopeeVoucher\ListShopeeVoucherAction;
use App\Http\Requests\ShopeeVoucher\ListShopeeVoucherRequest;
use Illuminate\Routing\Controller;
use App\Http\Resources\ShopeeVoucher\ShopeeVoucherCollection;

class ListShopeeVoucherController extends Controller
{
    /**
     * @param ListShopeeVoucherRequest $request
     * @return mixed
     */
    public function __invoke(ListShopeeVoucherRequest $request)
    {
        $data = resolve(ListShopeeVoucherAction::class)->setRequest($request)->handle();
        return (new ShopeeVoucherCollection($data));
    }
}
