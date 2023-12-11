<?php

namespace App\Http\Actions\Order;

use App\Repositories\OrderRepository;
use App\Repositories\OrderProductRepository;
use App\Http\Shared\Actions\BaseAction;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;
use App\Repositories\Criteria\OrderCriteria;
use App\Repositories\Criteria\WithRelationCriteria;

class DetailOrderAction extends BaseAction
{
    protected $orderRepository;
    protected $orderProductRepository;

    public function __construct
    (
        OrderRepository $orderRepository,
        OrderProductRepository $orderProductRepository,
    )
    {
        $this->orderRepository = $orderRepository;
        $this->orderProductRepository = $orderProductRepository;
    }

    public function handle()
    {
        $orderID = $this->params['orderID'];
        $order = $this->orderRepository->where(['id' => $orderID])->first();
        $orderProduct = $this->orderProductRepository->where(['order_id' => $orderID])->get();

        foreach ($orderProduct as $key => $value) {
            $product = Product::withTrashed()->findOrFail($value->product_id);
            $dataOrderProduct[] = [
                'id' => $value->id,
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'deleted_at' => $product->deleted_at,
                    'images' => $product->images
                ],
                'quantity' => $value->quantity,
                'total' => $value->quantity,
                'quantity' => $value->quantity,
                'price' => $value->price,
            ];
        }

        $data = [
            'order' => $order,
            'user' => auth()->user(),
            'order_product' => $dataOrderProduct,
            'shop' => Shop::withTrashed()->where('id', $order->shop_id)->first()
        ];

        return array_merge($data);
    }
}
