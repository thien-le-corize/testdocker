<?php

namespace App\Http\Controllers\Product;

use Illuminate\Routing\Controller;
use App\Http\Actions\Product\ApprovalProductAction;
use App\Http\Requests\Product\ApprovalProductRequest;

class ApprovalProductController extends Controller
{
    /**
     * @param ApprovalProductRequest $request
     * @return mixed
     */
    public function __invoke(ApprovalProductRequest $request)
    {
        $data = resolve(ApprovalProductAction::class)->setRequest($request)->handle();
        return $data;
    }
}
