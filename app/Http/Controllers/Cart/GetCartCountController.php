<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Routing\Controller;
use App\Http\Actions\Cart\GetCartAction;
use App\Http\Requests\Cart\GetCartRequest;

class GetCartCountController extends Controller
{
    /**
     * @param GetCartRequest $request
     * @return mixed
     */
    public function __invoke(GetCartRequest $request)
    {
        $data = resolve(GetCartAction::class)->setRequest($request)->handle();
        return $data;
    }
}
