<?php

namespace App\Http\Resources\Voucher;

use App\Http\Shared\Resources\BaseResource;

class VoucherResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->resource->only([
            'id',
            'name',
            'discount',
            'start_at',
            'end_at',
            'description',
            'type_reduction',
            'usage_quantity',
            'rule',
            'max_value_reduction',
            'min_price'
        ]);
    }
}
