<?php

namespace App\Http\Resources\Review;

use App\Http\Shared\Resources\BaseResource;

class ReviewResource extends BaseResource
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
            'rating',
            'comment',
            'created_at'
        ]);
        $data['user'] = $this->user->only($this->onlyAttributes());

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
