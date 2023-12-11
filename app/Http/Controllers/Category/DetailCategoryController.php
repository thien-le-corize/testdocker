<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Routing\Controller;
use App\Http\Actions\Category\DetailCategoryAction;
use App\Http\Requests\Category\DetailCategoryRequest;


class DetailCategoryController extends Controller
{
    /**
     * @param DetailCategoryRequest $request
     * @return mixed
     */
    public function __invoke(DetailCategoryRequest $request, $id)
    {
        $data = resolve(DetailCategoryAction::class)
        ->setRequest($request)
        ->setParams(['id' => $id])
        ->handle();
    
        return $data;
    }
}
