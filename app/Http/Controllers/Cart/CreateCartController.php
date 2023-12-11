<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Routing\Controller;
use App\Http\Actions\Cart\CreateCartAction;
use App\Http\Requests\Cart\CreateCartRequest;

class CreateCartController extends Controller
{
    /**
     * @param CreateCartRequest $request
     * @return mixed
     */
    public function __invoke(CreateCartRequest $request)
    {
        $data = resolve(CreateCartAction::class)->setRequest($request)->handle();
        return $data;
    }
}
