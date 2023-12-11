<?php

namespace App\Http\Controllers\Category;

use Illuminate\Routing\Controller;
use App\Http\Actions\Category\DeleteCategoryAction;
use App\Http\Requests\Category\DeleteCategoryRequest;

class DeleteCategoryController extends Controller
{
    /**
     * @param DeleteCategoryRequest $request
     * @return mixed
     */
    public function __invoke(DeleteCategoryRequest $request)
    {
        $data = resolve(DeleteCategoryAction::class)->setRequest($request)->handle();
        return $data;
    }
}
