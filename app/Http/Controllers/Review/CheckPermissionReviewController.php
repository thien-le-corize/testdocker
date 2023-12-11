<?php

namespace App\Http\Controllers\Review;

use App\Http\Actions\Review\CheckPermissionReviewAction;
use App\Http\Requests\Review\CheckPermissionReviewRequest;
use Illuminate\Routing\Controller;

class CheckPermissionReviewController extends Controller
{
    /**
     * @param CheckPermissionReviewRequest $request
     * @return mixed
     */
    public function __invoke(CheckPermissionReviewRequest $request)
    {
        $data = resolve(CheckPermissionReviewAction::class)->setRequest($request)->handle();
        return $data;
    }
}
