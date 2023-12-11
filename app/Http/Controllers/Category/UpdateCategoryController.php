<?php

namespace App\Http\Controllers\Category;

use Illuminate\Routing\Controller;
use App\Http\Actions\Category\UpdateCategoryAction;
use App\Http\Requests\Category\UpdateCategoryRequest;

class UpdateCategoryController extends Controller
{
    /**
     * @param UpdateCategoryRequest $request
     * @return mixed
     */
    public function __invoke(UpdateCategoryRequest $request)
    {
        $data = resolve(UpdateCategoryAction::class)->setRequest($request)->handle();
        return $data;
    }
}
