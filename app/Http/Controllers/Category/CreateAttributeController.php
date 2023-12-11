<?php

namespace App\Http\Controllers\Category;

use Illuminate\Routing\Controller;
use App\Http\Actions\Category\CreateAttributeAction;
use App\Http\Requests\Category\CreateAttributeRequest;

class CreateAttributeController extends Controller
{
    /**
     * @param CreateAttributeRequest $request
     * @return mixed
     */
    public function __invoke(CreateAttributeRequest $request)
    {
        $data = resolve(CreateAttributeAction::class)->setRequest($request)->handle();
        return $data;
    }
}
