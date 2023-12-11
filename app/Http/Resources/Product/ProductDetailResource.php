<?php

namespace App\Http\Resources\Product;

use App\Http\Shared\Resources\BaseResource;

class ProductDetailResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function toArray($request)
    {
        $data =  $this->resource->only([
            'id',
            'name',
            'description',
            'weight',
            'price',
            'quantity',
            'created_at',
            'category',
            'images',
            'videos',
            'shop',
            'attributes'
        ]);
        return $data;
    }
}
