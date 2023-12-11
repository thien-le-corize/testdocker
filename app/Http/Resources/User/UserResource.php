<?php

namespace App\Http\Resources\User;

use App\Http\Shared\Resources\BaseResource;

class UserResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = $this->resource->only([
            'id',
            'name',
            'phone',
            'email',
            'isValid',
            'role_id',
            'created_at',
        ]);

        $data['shop'] = $this->getRelationValue('shop');
        return $data;
    }
}
