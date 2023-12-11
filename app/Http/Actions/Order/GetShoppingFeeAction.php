<?php

namespace App\Http\Actions\Order;

use App\Models\Shop;
use App\Models\Address;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Repositories\OrderRepository;
use App\Http\Shared\Actions\BaseAction;
use App\Repositories\ProductRepository;
use App\Repositories\CartItemRepository;
use App\Repositories\OrderProductRepository;
use Illuminate\Validation\ValidationException;

class GetShoppingFeeAction extends BaseAction
{
    protected $productRepository;
    protected $orderRepository;
    protected $orderProductRepository;
    protected $cartItemRepository;


    public function __construct
    (
        OrderRepository $orderRepository,
        ProductRepository $productRepository,
        OrderProductRepository $orderProductRepository,
        CartItemRepository $cartItemRepository,
    )
    {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->orderProductRepository = $orderProductRepository;
        $this->cartItemRepository = $cartItemRepository;
    }
    
    public function handle()
    {
        $data = $this->request->all();

        $amount = 0;
        $weight = 0;
        $shippingFee = 0;
        $infoUserBuy = $this->getInfoUserBuy($data);
        $reductionPrice = 0;
        foreach ($data['data_order'] as $key => $value) {
            $shopIdGHN = $this->getShopIdGHN($value['shop_id']);
            $cartItems = $this->cartItemRepository->whereIn('id', $value['cart_item_ids'])->get();
            
            $shop = Shop::with('vouchers')->where('id', $value['shop_id'])->first();
            $vouchers = $shop->vouchers;

            foreach ($cartItems as $cartItem) {
                $amount += $cartItem->getRelationValue('product')->price * $cartItem->quantity;
                $weight += $cartItem->getRelationValue('product')->weight * $cartItem->quantity;
            }
            $shippingFee += $this->getShippingFee($infoUserBuy, $weight, $shopIdGHN);
            $totalAmount = $amount + $shippingFee;

            // logic handle apply voucher shop
            if(!empty($value['voucher_id'])){
                $reductionPrice = $this->calculateDiscount($vouchers, $value['voucher_id'], $totalAmount);
            }
        }
        
        $totalAmount = $amount + $shippingFee - $reductionPrice;
        return [
            'amount' => $amount,
            'shipping_fee' => $shippingFee,
            'total_amount' => $totalAmount,
            'discount' => $reductionPrice
        ];
    }

    public function getShippingFee($dataInfoUserBuy, $weight, $shopId)
    {
        $data = [
            'service_type_id' => 2,
            'to_district_id' => $dataInfoUserBuy['to_district_id'],
            'to_ward_code' => $dataInfoUserBuy['to_ward_code'],
            'weight' => $weight,
            'height' => 10,
            'length' => 10,
            'width' => 10,
        ];

        $response = Http::withHeaders([
            'Token' => config('ghn.token'),
            'ShopId' => $shopId,
            'Content-Type' => 'application/json',
        ])
        ->get(config('ghn.api.order_shipping_fee'), $data);
        return json_decode($response['data']['total']);
    }

    public function getInfoUserBuy($data)
    {
        $user = auth()->user();
        $address = Address::where([
            'id' => $data['address_id'],
            'user_id' => $user->id
        ]);
        
        $district_id = $address->select(DB::raw("district->>'district_id' as district_id"))->pluck('district_id')->first();
        $ward_code = $address->select(DB::raw("ward->>'ward_code' as ward_code"))->pluck('ward_code')->first();
    
        $dataInfoUserBuy = [
            'to_name' => optional($user)->getAttribute('name'),
            'to_phone' => optional($user)->getAttribute('phone'),
            'to_address' => $address->select(DB::raw("address"))->pluck('address')->first(),
            'to_ward_code' => $ward_code,
            'to_district_id' => $district_id,
        ];
        return $dataInfoUserBuy;
    }


    public function getShopIdGHN($shopId)
    {
        return Shop::where('id', $shopId)->first()->shop_id;
    }

    public function calculateDiscount($vouchers, $voucherId, $totalAmount)
    {
        $voucher = $vouchers->where('id', $voucherId)->where('end_at', '>=', date('Y-m-d'))->first();
        if($voucher) {
            if($totalAmount >= $voucher->min_price) {
                $reductionPrice = $this->calcReduction($totalAmount, $voucher);
                $totalAmount = $totalAmount - $reductionPrice;
                return (int)$reductionPrice;
            }
            throw ValidationException::withMessages(['code_message_value' => $voucher->shop_id .'::Giá trị đơn hàng của shop nhỏ hơn giá tối thiểu được áp dụng mã giảm giá này!']);
        } else {
            throw ValidationException::withMessages(['voucher_invalid' =>  $voucher->shop_id .'::Mã giảm giá mà bạn áp dụng không tồn tại hoặc đã hết hạn!']);
        }
    }

    public function calcReduction($totalAmount, $voucher) {
        $maxValue = $voucher->max_value_reduction;
        $discount = $voucher->discount;
        $type = $voucher->type_reduction;
        $discountType = $voucher->discount_type;
        if($discountType == 1) {
            if($type == 1) {
                $reducedPrice = $totalAmount * $discount/100;
                $reducedPrice = $reducedPrice > $maxValue ? $maxValue : $reducedPrice;
            } else {
                $reducedPrice = $totalAmount * $discount;
            }
        } else {
            $reducedPrice = $discount;
        }

        return $reducedPrice;
    }
}
