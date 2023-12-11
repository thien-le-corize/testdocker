<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Routing\Controller;
use App\Http\Actions\Cart\UpdateCartAction;
use App\Http\Requests\Cart\UpdateCartRequest;

class UpdateCartController extends Controller
{
    /**
     * @param UpdateCartRequest $request
     * @return mixed
     */
    public function __invoke(UpdateCartRequest $request)
    {
        $data = resolve(UpdateCartAction::class)->setRequest($request)->handle();
        return $data;
    }
}
