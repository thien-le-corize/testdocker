<?php

namespace App\Http\Controllers\Category;

use Illuminate\Routing\Controller;
use App\Http\Actions\Category\CreateAttributeValueAction;
use App\Http\Requests\Category\CreateAttributeValueRequest;

class CreateAttributeValueController extends Controller
{
    /**
     * @param CreateAttributeValueRequest $request
     * @return mixed
     */
    public function __invoke(CreateAttributeValueRequest $request)
    {
        $data = resolve(CreateAttributeValueAction::class)->setRequest($request)->handle();
        return $data;
    }
}
