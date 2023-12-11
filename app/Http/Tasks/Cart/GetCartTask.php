<?php

namespace App\Http\Tasks\Cart;

use App\Models\Shop;
use App\Repositories\CartItemRepository;

class GetCartTask
{
    protected $cartItemRepository;

    public function __construct(CartItemRepository $cartItemRepository)
    {
        $this->cartItemRepository = $cartItemRepository;
    }

    public function handle($carts)
    {
        $result = [];
        $cartIds = [];
        foreach ($carts as $cart) {
            $cartItems = [];

            foreach ($cart->cartItems as $cartItem) {
                $cartItems[] = [
                    'id' => $cartItem->id,
                    'products' => [
                        'id' => $cartItem->product->id,
                        'name' => $cartItem->product->name,
                        'quantity' => $cartItem->product->quantity,
                        'price' => $cartItem->product->price,
                        'images' => $cartItem->product->images,
                        'deleted_at' => $cartItem->product->deleted_at,
                    ],
                    'quantity' => $cartItem->quantity
                ];
            }

            $result[] = [
                'id' => $cart->id,
                'count' => count($cartItems),
                'cart_items' => $cartItems,
                'shop' => Shop::withTrashed()->find($cart->shop_id),
            ];

            $cartIds[] = $cart->id;
        }

        return [
            'cart_datas' => $result,
            'total' => $this->cartItemRepository->whereIn('cart_id', $cartIds)->count()
        ];
    }
    
}
