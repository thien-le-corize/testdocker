<?php

namespace App\Http\Controllers\Address;

use Illuminate\Routing\Controller;
use App\Http\Actions\Address\DetailAddressAction;
use App\Http\Requests\Address\DetailAddressRequest;

class DetailAddressController extends Controller
{
    /**
     * @param DetailAddressRequest $request
     * @return mixed
     */
    public function __invoke(DetailAddressRequest $request, $id)
    {
        $data = resolve(DetailAddressAction::class)
        ->setParams(['id' => $id])
        ->setRequest($request)->handle();
        return $data;
    }
}
