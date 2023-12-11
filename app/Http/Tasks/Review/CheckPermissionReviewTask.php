<?php

namespace App\Http\Tasks\Review;

use App\Models\Order;
use App\Repositories\OrderRepository;
use App\Repositories\ReviewRepository;
use Illuminate\Validation\ValidationException;

class CheckPermissionReviewTask
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
        $data = $request;
        $userId = auth()->user()->id;
       
        $orders = $this->orderRepository->where([
                'user_id' => $userId,
                'status' => Order::COMPLETED,
                'payment_status' => true
            ])->get();

        $isPermissionReview = false;

        $isReviewed = $this->reviewRepository->where([
            'user_id' => $userId,
            'product_id' => $data['product_id'] 
        ])->first();

        if(!is_null($isReviewed)){
            throw ValidationException::withMessages(['code_message_value' => 'Bạn chỉ có thể bình luận 1 lần']);
        }

        $data['user_id'] = $userId;
        foreach ($orders as $order) {
            foreach ($order->orderProducts as $item) {
                if($data['product_id'] == $item->product_id){
                    $isPermissionReview = true;
                    break;
                }
            }
        }

        return [
            'isPermissionReview' => $isPermissionReview
        ];
    }
}
