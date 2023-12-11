<?php

namespace App\Http\Controllers\ShopeeVoucher;

use App\Http\Actions\ShopeeVoucher\UpdateShopeeVoucherAction;
use App\Http\Requests\ShopeeVoucher\UpdateShopeeVoucherRequest;
use Illuminate\Routing\Controller;

class UpdateShopeeVoucherController extends Controller
{
    /**
     * @param UpdateShopeeVoucherRequest $request
     * @return mixed
     */
    public function __invoke(UpdateShopeeVoucherRequest $request)
    {
        $data = resolve(UpdateShopeeVoucherAction::class)->setRequest($request)->handle();
        return $data;
    }
}
