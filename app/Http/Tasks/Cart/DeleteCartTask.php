<?php

namespace App\Http\Tasks\Cart;

use App\Repositories\CartItemRepository;
use App\Repositories\CartRepository;
use Illuminate\Support\Facades\DB;

class DeleteCartTask
{
    protected $cartItemRepository;
    protected $cartRepository;

    public function __construct
    (
        CartItemRepository $cartItemRepository,
        CartRepository $cartRepository
    )
    {
        $this->cartItemRepository = $cartItemRepository;
        $this->cartRepository = $cartRepository;
    }

    public function handle($data)
    {
        DB::beginTransaction();
        if(isset($data['shop_id'])){
            $cart = $this->cartRepository->where([
                'user_id' => auth()->user()->id,
                'shop_id' => $data['shop_id'],
            ])->first();
            $this->cartItemRepository->where(['cart_id' => $cart->id])->delete();
            $cart->delete();
        }else{
            $cartIdDelete = $this->checkDeleteCart($data['cart_item_id']);
            $this->cartItemRepository->whereIn('id', $data['cart_item_id'])->delete();
            if(!empty($cartIdDelete)){
                $this->cartRepository->whereIn('id', $cartIdDelete)->delete();
            }
        }
        DB::commit();
    }

    public function checkDeleteCart($dataItem){
        $data = [];
        foreach ($dataItem as $key => $value) {
            $cartId = $this->cartItemRepository->where(['id' => $value])->first()->cart_id;

            $isDeleteCart = $this->cartItemRepository->whereNotIn('id', $dataItem)
                ->where(['cart_id' => $cartId])->first();
             
            if(is_null($isDeleteCart)){
                $data[] = $cartId;
            }
        }
        return array_unique($data);
    }
}
