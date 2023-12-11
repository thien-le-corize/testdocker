<?php

namespace App\Http\Controllers\Address;

use Illuminate\Routing\Controller;
use App\Http\Actions\Address\GetDistrictAction;
use App\Http\Requests\Address\GetDistrictRequest;

class GetDistrictController extends Controller
{
    /**
     * @param GetDistrictRequest $request
     * @return mixed
     */
    public function __invoke(GetDistrictRequest $request)
    {
        $data = resolve(GetDistrictAction::class)->setRequest($request)->handle();
        return $data;
    }
}
