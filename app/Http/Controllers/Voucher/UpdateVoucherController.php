<?php

namespace App\Http\Controllers\Voucher;

use App\Http\Actions\Voucher\UpdateVoucherAction;
use App\Http\Requests\Voucher\UpdateVoucherRequest;
use Illuminate\Routing\Controller;

class UpdateVoucherController extends Controller
{
    /**
     * @param UpdateVoucherRequest $request
     * @return mixed
     */
    public function __invoke(UpdateVoucherRequest $request)
    {
        $data = resolve(UpdateVoucherAction::class)->setRequest($request)->handle();
        return $data;
    }
}
