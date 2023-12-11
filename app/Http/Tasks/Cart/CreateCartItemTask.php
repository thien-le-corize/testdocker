<?php

namespace App\Http\Tasks\Cart;

use App\Models\Product;
use App\Repositories\CartItemRepository;
use Illuminate\Validation\ValidationException;

class CreateCartItemTask
{
    protected $cartItemRepository;

    public function __construct(CartItemRepository $cartItemRepository)
    {
        $this->cartItemRepository = $cartItemRepository;
    }

    public function handle($data, $cartId)
    {
        $cartItem =  $this->cartItemRepository->where([
            'product_id' => $data['product_id'],
            'cart_id' => $cartId
        ])->first();
            
        $dataCartItem = [
            'cart_id' => $cartId,
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity']
        ];
            
        if(is_null($cartItem)){
            $this->cartItemRepository->insertGetId($dataCartItem, false);
        }else{
            $quantityProduct = Product::where(['id' => $data['product_id']])->first()->quantity;

            $data['quantity'] += $cartItem->quantity;
            if($quantityProduct < $data['quantity']){
                throw ValidationException::withMessages([
                    __('errors.product.max', ['quantity' => $quantityProduct])
                ],
            );
            }
            $this->cartItemRepository->where(['id' => $cartItem->id])->update(['quantity' => $data['quantity']]);
        }

    }
}
