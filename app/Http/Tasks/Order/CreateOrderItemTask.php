<?php

namespace App\Http\Tasks\Order;

use App\Repositories\OrderProductRepository;

class CreateOrderItemTask
{
    protected $orderProductRepository;

    public function __construct
    (
        OrderProductRepository $orderProductRepository,
    )
    {
        $this->orderProductRepository = $orderProductRepository;
    }

    public function handle($data, $orderId)
    {
        $dataOrderProduct = [];
        foreach ($data as $value) 
        {
            $dataOrderProduct[] = [
                'product_id' => $value['product_id'],
                'order_id' => $orderId,
                'quantity' => $value['quantity'],
                'price' => $value['product']['price'],
                'total' => $value['quantity'] *  $value['product']['price']
            ];
        }
        $this->orderProductRepository->insert($dataOrderProduct, false);
    }
}
