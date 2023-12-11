<?php

namespace App\Http\Actions\Review;

use App\Models\Order;
use App\Exceptions\OrderException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\OrderRepository;
use App\Repositories\ReviewRepository;
use App\Http\Shared\Actions\BaseAction;

class CreateReviewAction extends BaseAction
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
        $orderId = $this->params['orderID'];
        $data = $this->request->all();

        DB::beginTransaction();
        $order = $this->orderRepository->findOrFail($orderId);
        
        $orderStatus = $order->status;

        Log::info(in_array(Order::COMPLETED, $orderStatus));
        Log::info($order->user_id == auth()->user()->id);
        Log::info( $order->isReview == false);

        if( in_array(Order::COMPLETED, $orderStatus) && $order->user_id == auth()->user()->id && $order->isReview){
            throw OrderException::orderNotReivew();
        }

        foreach ($data['data'] as $value) {
            $dataToInsert[] = [
                'rating' => $value['rating'],
                'comment' => $value['comment'],
                'product_id' => $value['product_id'],
                'user_id' => auth()->user()->id,
            ];
        }

        $this->reviewRepository->insert($dataToInsert, false);

         $this->orderRepository->findOrFail($orderId)->update([
            'is_review' => true
        ]);

        DB::commit();
        return $this->setMessage('create_success', 'review', null, null);
       
    }
}