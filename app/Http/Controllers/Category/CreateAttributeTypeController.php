<?php

namespace App\Http\Controllers\Category;

use Illuminate\Routing\Controller;
use App\Http\Actions\Category\CreateAttributeTypeAction;
use App\Http\Requests\Category\CreateAttributeTypeRequest;

class CreateAttributeTypeController extends Controller
{
    /**
     * @param CreateAttributeTypeRequest $request
     * @return mixed
     */
    public function __invoke(CreateAttributeTypeRequest $request)
    {
        $data = resolve(CreateAttributeTypeAction::class)->setRequest($request)->handle();
        return $data;
    }
}
