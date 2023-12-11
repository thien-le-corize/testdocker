<?php

namespace App\Http\Tasks\Cart;

use App\Models\Product;
use App\Repositories\CartItemRepository;
use Illuminate\Validation\ValidationException;

class UpdateCartTask
{
    protected $cartItemRepository;

    public function __construct(CartItemRepository $cartItemRepository)
    {
        $this->cartItemRepository = $cartItemRepository;
    }

    public function handle($data)
    {
        // dd(12312);
        $query = $this->cartItemRepository->where(['id' => $data['id']])->first();

        $quantity = isset($data['quantity']) ? $data['quantity'] : $query->quantity;

        $product = Product::where(['id' => $query->product_id])->first();

        if($product->quantity < $quantity){
            throw ValidationException::withMessages(['code_message_value' => $product->shop_id .'::Mặt hàng này chỉ còn '. $product->quantity .' lượng số lượng!']);
        }
        
        $query->update(['quantity' => $quantity]);
    }
}
