<?php

namespace App\Http\Tasks\Review;

use App\Models\Order;
use App\Repositories\OrderRepository;
use App\Repositories\ReviewRepository;
use Illuminate\Validation\ValidationException;

class GetReviewTask
{
    protected $reviewRepository;
    protected $orderRepository;

     /**
     * @var ReviewRepository $reviewRepository
     */
    public function __construct(ReviewRepository $reviewRepository, OrderRepository $orderRepository)
    {
        $this->reviewRepository = $reviewRepository;
        $this->orderRepository = $orderRepository;
    }

    public function handle($request)
    {
        $productId = $request['productId'];
        dd($productId);
    }
}
