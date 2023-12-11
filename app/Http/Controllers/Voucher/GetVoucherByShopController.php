<?php

namespace App\Http\Controllers\Voucher;

use App\Http\Actions\Voucher\GetVoucherByShopAction;
use App\Http\Requests\Voucher\GetVoucherByShopRequest;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class GetVoucherByShopController extends Controller
{
    /**
     * @param GetVoucherByShopRequest $request
     * @return mixed
     */
    public function __invoke(GetVoucherByShopRequest $request, $shopId)
    {
        $data = resolve(GetVoucherByShopAction::class)
            ->setParams(['shopId' => $shopId])
            ->setRequest($request)
            ->handle();
            
        return $data;
    }
}
