<?php

namespace App\Http\Controllers\ShopeeVoucher;

use App\Http\Actions\ShopeeVoucher\CreateShopeeVoucherAction;
use App\Http\Requests\ShopeeVoucher\CreateShopeeVoucherRequest;
use Illuminate\Routing\Controller;

class CreateShopeeVoucherController extends Controller
{
    /**
     * @param CreateShopeeVoucherRequest $request
     * @return mixed
     */
    public function __invoke(CreateShopeeVoucherRequest $request)
    {
        $data = resolve(CreateShopeeVoucherAction::class)->setRequest($request)->handle();
        return $data;
    }
}
