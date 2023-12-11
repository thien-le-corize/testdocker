<?php

namespace App\Http\Controllers\Product;

use Illuminate\Routing\Controller;
use App\Http\Actions\Product\CreateProductAction;
use App\Http\Requests\Product\CreateProductRequest;

class CreateProductController extends Controller
{
    /**
     * @param CreateProductRequest $request
     * @return mixed
     */
    public function __invoke(CreateProductRequest $request)
    {
        $data = resolve(CreateProductAction::class)->setRequest($request)->handle();
        return $data;
    }
}
