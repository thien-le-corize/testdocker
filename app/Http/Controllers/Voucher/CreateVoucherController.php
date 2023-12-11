<?php

namespace App\Http\Controllers\Voucher;

use App\Http\Actions\Voucher\CreateVoucherAction;
use App\Http\Requests\Voucher\CreateVoucherRequest;
use Illuminate\Routing\Controller;

class CreateVoucherController extends Controller
{
    /**
     * @param CreateVoucherRequest $request
     * @return mixed
     */
    public function __invoke(CreateVoucherRequest $request)
    {
        $data = resolve(CreateVoucherAction::class)->setRequest($request)->handle();
        return $data;
    }
}
