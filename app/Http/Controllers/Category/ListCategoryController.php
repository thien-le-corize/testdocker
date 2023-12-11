<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Routing\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;
use App\Http\Actions\Category\ListCategoryAction;
use App\Http\Requests\Category\ListCategoryRequest;


class ListCategoryController extends Controller
{
    /**
     * @param ListCategoryRequest $request
     * @return mixed
     */
    public function __invoke(ListCategoryRequest $request)
    {
        $data = resolve(ListCategoryAction::class)->setRequest($request)->handle();
        return $data;
    }
}
