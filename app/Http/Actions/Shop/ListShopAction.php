<?php

namespace App\Http\Actions\Shop;

use App\Models\Shop;
use App\Repositories\ShopRepository;
use App\Http\Shared\Actions\BaseAction;
use App\Exceptions\AuthenticateException;
use App\Repositories\Criteria\OrderCriteria;
use App\Repositories\Criteria\WithRelationCriteria;

class ListShopAction extends BaseAction
{
    protected $shopRepository;

    public function __construct
    (
        ShopRepository $shopRepository,
    )
    {
        $this->shopRepository = $shopRepository;
    }

    public function handle()
    {
        $query = $this->shopRepository
            ->pushCriteria(new OrderCriteria($this->request->get('order')))
            ->pushCriteria(new WithRelationCriteria($this->request->get('with')));
        
        return $this->paginateOrAll($query->withTrashed());
    }
}
