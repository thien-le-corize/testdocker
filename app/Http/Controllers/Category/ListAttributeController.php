<?php

namespace App\Http\Controllers\Category;

use Illuminate\Routing\Controller;
use App\Http\Actions\Category\ListAttributeAction;
use App\Http\Requests\Category\ListAttributeRequest;


class ListAttributeController extends Controller
{
    /**
     * @param ListAttributeRequest $request
     * @return mixed
     */
    public function __invoke(ListAttributeRequest $request)
    {
        $data = resolve(ListAttributeAction::class)->setRequest($request)->handle();
        return $data;
    }
}
