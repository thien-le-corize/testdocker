<?php

namespace App\Http\Controllers\Review;

use App\Http\Actions\Review\GetReviewAction;
use App\Http\Requests\Review\GetReviewRequest;
use App\Http\Resources\Review\ReviewCollection;
use Illuminate\Routing\Controller;

class GetReviewController extends Controller
{
    /**
     * @param GetReviewRequest $request
     * @return mixed
     */
    public function __invoke(GetReviewRequest $request, $productId)
    {
        $data = resolve(GetReviewAction::class)->setParams(['productId' => $productId])->handle();
        return (new ReviewCollection($data));
    }
}
