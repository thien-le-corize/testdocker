<?php

namespace App\Http\Controllers\Category;

use Illuminate\Routing\Controller;
use App\Http\Actions\Category\ListCategoryOfUserAction;
use App\Http\Requests\Category\ListCategoryOfUserRequest;


class ListCategoryOfUserController extends Controller
{
    /**
     * @param ListCategoryOfUserRequest $request
     * @return mixed
     */
    public function __invoke(ListCategoryOfUserRequest $request)
    {
        $data = resolve(ListCategoryOfUserAction::class)->setRequest($request)->handle();
        return $data;
    }
}
