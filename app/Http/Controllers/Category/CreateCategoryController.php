<?php

namespace App\Http\Controllers\Category;

use Illuminate\Routing\Controller;
use App\Http\Actions\Category\CreateCategoryAction;
use App\Http\Requests\Category\CreateCategoryRequest;

class CreateCategoryController extends Controller
{
    /**
     * @param CreateCategoryRequest $request
     * @return mixed
     */
    public function __invoke(CreateCategoryRequest $request)
    {
        $data = resolve(CreateCategoryAction::class)->setRequest($request)->handle();
        return $data;
    }
}
