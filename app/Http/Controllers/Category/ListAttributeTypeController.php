<?php

namespace App\Http\Controllers\Category;

use Illuminate\Routing\Controller;
use App\Http\Actions\Category\ListAttributeTypeAction;
use App\Http\Requests\Category\ListAttributeTypeRequest;


class ListAttributeTypeController extends Controller
{
    /**
     * @param ListAttributeTypeRequest $request
     * @return mixed
     */
    public function __invoke(ListAttributeTypeRequest $request)
    {
        $data = resolve(ListAttributeTypeAction::class)->setRequest($request)->handle();
        return $data;
    }
}
