<?php

namespace App\Http\Controllers\Voucher;

use App\Http\Actions\Voucher\ListVoucherAction;
use App\Http\Requests\Voucher\ListVoucherRequest;
use Illuminate\Routing\Controller;
use App\Http\Resources\Voucher\VoucherCollection;

class ListVoucherController extends Controller
{
    /**
     * @param ListVoucherRequest $request
     * @return mixed
     */
    public function __invoke(ListVoucherRequest $request)
    {
        $data = resolve(ListVoucherAction::class)->setRequest($request)->handle();
        return (new VoucherCollection($data));
    }
}
