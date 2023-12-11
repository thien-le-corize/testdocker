<?php

namespace App\Http\Controllers\Address;

use Illuminate\Routing\Controller;
use App\Http\Actions\Address\GetWardAction;
use App\Http\Requests\Address\GetWardRequest;

class GetWardController extends Controller
{
    /**
     * @param GetWardRequest $request
     * @return mixed
     */
    public function __invoke(GetWardRequest $request)
    {
        $data = resolve(GetWardAction::class)->setRequest($request)->handle();
        return $data;
    }
}
