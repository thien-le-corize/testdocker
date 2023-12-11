<?php

namespace App\Http\Shared\Resources;

use App\Http\Shared\Resources\ResourceResponse;
use Illuminate\Http\Resources\Json\JsonResource;

/** @SuppressWarnings(PHPMD.NumberOfChildren) */
class BaseResource extends JsonResource
{
    /**
     * The additional meta data that should be added to the resource response.
     *
     * Added during response construction by the developer.
     *
     * @var array
     */
    public $additional = [
        'success' => true,
    ];

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        return (new ResourceResponse($this))->toResponse($request);
    }
}
