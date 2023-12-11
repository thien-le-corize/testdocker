<?php

namespace App\Http\Controllers\Product;

use Illuminate\Routing\Controller;
use App\Http\Actions\Product\UpdateProductAction;
use App\Http\Requests\Product\UpdateProductRequest;

class UpdateProductController extends Controller
{
    /**
     * @param UpdateProductRequest $request
     * @return mixed
     */
    public function __invoke(UpdateProductRequest $request)
    {
        $data = resolve(UpdateProductAction::class)->setRequest($request)->handle();
        return $data;
    }
}
