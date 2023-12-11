<?php

namespace App\Http\Resources\Shop;

use App\Models\User;
use App\Http\Shared\Resources\BaseResource;

class ShopResource extends BaseResource
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
        $data = $this->resource->only([
            'id',
            'shop_name',
            'shop_id',
            'address',
            'created_at',
            'deleted_at',
        ]);
        $data['user'] = User::where('shop_id', $this->id)->first();
        return $data;
    }
}
