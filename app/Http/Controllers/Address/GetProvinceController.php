<?php

namespace App\Http\Controllers\Address;

use Illuminate\Routing\Controller;
use App\Http\Actions\Address\GetProvinceAction;
use App\Http\Requests\Address\GetProvinceRequest;

class GetProvinceController extends Controller
{
    /**
     * @param GetProvinceRequest $request
     * @return mixed
     */
    public function __invoke(GetProvinceRequest $request)
    {
        $data = resolve(GetProvinceAction::class)->setRequest($request)->handle();
        return $data;
    }
}
