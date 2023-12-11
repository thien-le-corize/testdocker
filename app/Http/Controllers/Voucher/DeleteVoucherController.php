<?php

namespace App\Http\Controllers\Voucher;

use App\Http\Actions\Voucher\DeleteVoucherAction;
use App\Http\Requests\Voucher\DeleteVoucherRequest;
use Illuminate\Routing\Controller;

class DeleteVoucherController extends Controller
{
    /**
     * @param DeleteVoucherRequest $request
     * @return mixed
     */
    public function __invoke(DeleteVoucherRequest $request, $id)
    {
        $data = resolve(DeleteVoucherAction::class)->setRequest($request)->setParams(['id' => $id])->handle();
        return $data;
    }
}
