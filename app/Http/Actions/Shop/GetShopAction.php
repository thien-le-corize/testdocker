<?php

namespace App\Http\Actions\Shop;

use App\Models\Shop;
use App\Repositories\ShopRepository;
use App\Http\Shared\Actions\BaseAction;
use App\Exceptions\AuthenticateException;

class GetShopAction extends BaseAction
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
        $shopId = $this->params['id'];
        $shop = $this->shopRepository->with('products.category')->findOrFail($shopId);

        $products = $shop->products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'weight' => $product->weight,
                'price' => $product->price,
                'quantity' => $product->quantity,
                'created_at' => $product->created_at,
                'category' => $product->category->toArray(),
                'images' => $product->images,
                'videos' => $product->videos,
            ];
        });

        $categories = $products->pluck('category')->unique();

        $data = [
            'shop' => $shop,
            'products' => $products->toArray(),
            'categories' => $categories->values()->toArray(),
        ];

        unset($data['shop']['products']);
        return $data;
    }
}
