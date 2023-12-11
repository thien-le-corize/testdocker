<?php

namespace App\Http\Actions\Review;


use App\Http\Shared\Actions\BaseAction;
use App\Repositories\OrderRepository;
use App\Repositories\ReviewRepository;

class GetReviewAction extends BaseAction
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

    public function handle()
    {   
        $productId = $this->params['productId'];

        $query = $this->reviewRepository->where(['product_id' => $productId])->orderByDesc('created_at')->get();

        return $query;
    }
}