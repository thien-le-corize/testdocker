<?php

namespace App\Http\Controllers\Product;

use Illuminate\Routing\Controller;
use App\Http\Actions\Product\CreateWishListProductAction;
use App\Http\Requests\Product\CreateWishListProductRequest;

class CreateWishListProductController extends Controller
{
    /**
     * @param CreateWishListProductRequest $request
     * @return mixed
     */
    public function __invoke(CreateWishListProductRequest $request)
    {
        $data = resolve(CreateWishListProductAction::class)->setRequest($request)->handle();
        return $data;
    }
}
