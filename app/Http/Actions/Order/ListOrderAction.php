<?php

namespace App\Http\Actions\Order;

use App\Repositories\OrderRepository;
use App\Http\Shared\Actions\BaseAction;
use App\Repositories\Criteria\OrderCriteria;
use App\Repositories\Criteria\WithRelationCriteria;

class ListOrderAction extends BaseAction
{
    protected $orderRepository;

    public function __construct
    (
        OrderRepository $orderRepository,
    )
    {
        $this->orderRepository = $orderRepository;
    }

    public function handle()
    {
        $isPurchase = $this->request['is_purchase'];

        $user = auth()->user();

        $query = $this->orderRepository
            ->orderBy('created_at', 'desc')
            ->pushCriteria(new OrderCriteria($this->request->get('order')))
            ->pushCriteria(new WithRelationCriteria($this->request->get('with')));

        $query = (int)$isPurchase 
            ? $query->where(['user_id' => $user->id])
            : $query->where(['shop_id' => optional($user)->getRelationValue('shop')?->id]);

        return $this->paginateOrAll($query->filter());
    }
}
