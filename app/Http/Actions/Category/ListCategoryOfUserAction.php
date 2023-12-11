<?php

namespace App\Http\Actions\Category;

use App\Http\Shared\Actions\BaseAction;
use App\Repositories\ProductRepository;

class ListCategoryOfUserAction extends BaseAction
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
        // dd($this->request->all());
        $shopId = $this->request->get('shop_id') ?? optional(auth()->user())?->getRelationValue('shop')?->id ?? null;
        // dd($shopId);
        $products = $this->productRepository->where(['shop_id' => $shopId])->get();
        foreach ($products as  $product) {
            $data['category'][] = $product->getRelationValue('category')->toArray();
        }

        return $data;
    }
}
