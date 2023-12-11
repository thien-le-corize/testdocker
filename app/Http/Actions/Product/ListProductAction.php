<?php

namespace App\Http\Actions\Product;

use App\Models\Product;
use App\Http\Shared\Actions\BaseAction;
use App\Repositories\ProductRepository;
use App\Repositories\Criteria\OrderCriteria;
use App\Repositories\Criteria\WithRelationCriteria;

class ListProductAction extends BaseAction
{
    protected $productRepository;


    public function __construct
    (
        ProductRepository $productRepository,
    )
    {
        $this->productRepository = $productRepository;
    }

    public function handle()
    {
        $userId = $this->request->get('user_id') ?? null;

        $conditions = [
            'status' => Product::ACTIVE
        ];
        
        if(!is_null($userId)){
            $conditions['user_id'] = $userId;
        }
        
        $query = $this->productRepository
            ->pushCriteria(new OrderCriteria($this->request->get('order')))
            ->pushCriteria(new WithRelationCriteria($this->request->get('with')));

            
        $query = $this->productRepository->when($this->request->has('min_price') && $this->request->has('max_price'), function ($query) {
            return $query->whereBetween('price', [$this->request['min_price'], $this->request['max_price']]);
        })
        ->when($this->request->has('min_price'), function ($query) {
            return $query->where('price', '>=', $this->request['min_price']);
        })
        ->when($this->request->has('max_price'), function ($query) {
            return $query->where('price', '<=', $this->request['max_price']);
        })
        ->when($this->request->has('product_ids'), function ($query) {
            return $query->whereIn('id', json_decode($this->request['product_ids']));
        });
        
        
        return $this->paginateOrAll($query->withTrashed()->where($conditions)->filter());
    }
}
