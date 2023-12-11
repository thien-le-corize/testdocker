<?php

namespace App\Http\Resources\Order;

use App\Http\Shared\Resources\BaseResource;

class OrderProductResource extends BaseResource
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
            'order_code',
            'total_amount',
            'amount',
            'shipping_fee',
            'discount',
            'status',
            'created_at',
        ]);
        // $data['product'] = $this->address->only(['id', 'name', 'phone']);
        // $data['user'] = $this->user->only(['id', 'name']);
        // $data['shop'] = $this->shop->only(['shop_name']);

        return $data;
    }

    public function onlyAttributes()
    {
        return [
            'id',
            'name'
        ];
    }
}
