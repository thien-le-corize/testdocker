<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Routing\Controller;
use App\Http\Actions\Cart\DeleteCartAction;
use App\Http\Requests\Cart\DeleteCartRequest;

class DeleteCartController extends Controller
{
    /**
     * @param DeleteCartRequest $request
     * @return mixed
     */
    public function __invoke(DeleteCartRequest $request)
    {
        $data = resolve(DeleteCartAction::class)->setRequest($request)->handle();
        return $data;
    }
}
