<?php

namespace App\Http\Controllers\Address;

use Illuminate\Routing\Controller;
use App\Http\Actions\Address\CreateAddressAction;
use App\Http\Requests\Address\CreateAddressRequest;

class CreateAddressController extends Controller
{
    /**
     * @param CreateAddressRequest $request
     * @return mixed
     */
    public function __invoke(CreateAddressRequest $request)
    {
        $data = resolve(CreateAddressAction::class)->setRequest($request)->handle();
        return $data;
    }
}
