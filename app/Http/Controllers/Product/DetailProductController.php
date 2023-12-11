<?php

namespace App\Http\Controllers\Product;

use Illuminate\Routing\Controller;
use App\Http\Actions\Product\DetailProductAction;
use App\Http\Requests\Product\DetailProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductDetailCollection;

class DetailProductController extends Controller
{
    /**
     * @param DetailProductRequest $request
     * @return mixed
     */
    public function __invoke(DetailProductRequest $request, $id)
    {
        $data = resolve(DetailProductAction::class)
            ->setRequest($request)
            ->setParams(['id' => $id])
            ->handle();
        
        return $data;
    }
}
