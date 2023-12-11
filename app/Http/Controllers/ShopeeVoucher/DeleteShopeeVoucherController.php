<?php

namespace App\Http\Controllers\ShopeeVoucher;

use App\Http\Actions\ShopeeVoucher\DeleteShopeeVoucherAction;
use App\Http\Requests\ShopeeVoucher\DeleteShopeeVoucherRequest;
use Illuminate\Routing\Controller;

class DeleteShopeeVoucherController extends Controller
{
    /**
     * @param DeleteShopeeVoucherRequest $request
     * @return mixed
     */
    public function __invoke(DeleteShopeeVoucherRequest $request, $id)
    {
        $data = resolve(DeleteShopeeVoucherAction::class)->setRequest($request)->setParams(['id' => $id])->handle();
        return $data;
    }
}
