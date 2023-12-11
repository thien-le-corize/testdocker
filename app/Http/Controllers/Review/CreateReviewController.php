<?php

namespace App\Http\Controllers\Review;

use App\Http\Actions\Review\CreateReviewAction;
use App\Http\Requests\Review\CreateReviewRequest;
use Illuminate\Routing\Controller;

class CreateReviewController extends Controller
{
    /**
     * @param CreateReviewRequest $request
     * @return mixed
     */
    public function __invoke(CreateReviewRequest $request, $orderID)
    {
        $data = resolve(CreateReviewAction::class)
            ->setRequest($request)
            ->setParams(['orderID' => $orderID])
            ->handle();
        return $data;
    }
}
