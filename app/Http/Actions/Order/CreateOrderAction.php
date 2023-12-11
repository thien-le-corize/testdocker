<?php

namespace App\Http\Actions\Order;

use App\Models\Shop;
use App\Models\Order;
use App\Helpers\Common;
use App\Models\Address;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Repositories\OrderRepository;
use App\Http\Shared\Actions\BaseAction;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Session;
use App\Repositories\CartItemRepository;
use App\Exceptions\AuthenticateException;
use App\Repositories\OrderProductRepository;
use App\Http\Tasks\Order\CreateOrderItemTask;
use Illuminate\Validation\ValidationException;
use App\Http\Actions\Order\GetUrlPaymentAction;
use App\Models\Cart;
use App\Models\CartItem;

class CreateOrderAction extends BaseAction
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

    /**
     * @return \Illuminate\Support\Collection|mixed
     * @throws \Exception
     */
    public function handle()
    {
        $data = $this->request->all();

        $amount = 0;
        $weight = 0;
        $countOrder = 0;
        $shippingFee = 0;
        $infoUserBuy = $this->getInfoUserBuy($data);
        $totalOrderAmount = 0;
        DB::beginTransaction();
        
        foreach ($data['data_order'] as $key => $value) {

            $cartItems = $this->cartItemRepository->whereIn('id', $value['cart_item_ids'])->get();
            $cartIds[] = $cartItems[0]->cart_id;

            $shop = Shop::with('vouchers')->where('id', $value['shop_id'])->first();
            if($shop == null){
                throw ValidationException::withMessages(['code_message_value' => 'Shop invalid']);
            }

            $shopIdGHN = $this->getShopIdGHN($shop->id);
            $vouchers = $shop->vouchers;
            foreach ($cartItems as $cartItem) {
                $cartItemIDs[] = $cartItem->id; 
                $amount += $cartItem->getRelationValue('product')->price * $cartItem->quantity;
                $weight += $cartItem->getRelationValue('product')->weight * $cartItem->quantity;
            }

            $items = $this->getItemOrder($cartItems);
            $shippingFee = $this->getShippingFee($infoUserBuy, $weight, $shopIdGHN);
            $totalAmount = $amount + $shippingFee;

            // logic handle apply voucher shop
            if(!empty($value['voucher_id'])){
                [$totalAmount, $reductionPrice, $voucher] = $this->calculateDiscount($vouchers, $value['voucher_id'], $totalAmount);
            }

            $orderDataGHN = $this->createOrderGHN($infoUserBuy, $weight, $shopIdGHN, $items, $data['payment_method'], $totalAmount);
            
            if(!empty($orderDataGHN['code_message']) ){
                if($orderDataGHN['code_message'] == 'PHONE_INVALID'){
                    throw ValidationException::withMessages(['error' => 'Invalid phone number. Please try again later']);
                }
                
                if($orderDataGHN['code_message'] == 'COD_IS_OVER_LIMIT'){
                    throw ValidationException::withMessages(['error' => 'COD value exceeds the allowed level: 50000000']);
                }

                if($orderDataGHN['code_message'] == 'SEND_DISTRICT_IS_DISABLED'){
                    throw ValidationException::withMessages(['error' => 'The sender district is currently not supported']);
                }

                if($orderDataGHN['code_message'] == 'SERVER_ERR_COMMON'){
                    throw ValidationException::withMessages(['error' => 'System error - could not get warehouse information. Please try again later']);
                }
            }

            $dataOrder = [
                'amount' => $amount,
                'total_amount' => $totalAmount,
                'user_id' => auth()->user()->id,
                'order_code' => $orderDataGHN['data']['order_code'],
                'payment_method' => $data['payment_method'],
                'address_id' => $data['address_id'],
                'shipping_fee' => $shippingFee,
                'note' => $value['note'] ?? null,
                'discount_amount' => $reductionPrice ?? null,
                'status' => DB::raw("'{" . Order::PENDING . "}'"),
                'shop_id' => $value['shop_id'],
                'voucher_id' => $value['voucher_id'] ?? null
            ];

            $orderId = $this->orderRepository->insertGetId($dataOrder, false);

            if(!empty($value['voucher_id'])){
                $voucher->usage_quantity = $voucher->usage_quantity - 1;
                $voucher->save();
            }

            $reductionPrice = 0;
            $amount = 0;
            $weight = 0;
            resolve(CreateOrderItemTask::class)->handle($cartItems->toArray(), $orderId);
            $countOrder++;
            $orderIds[] = $orderId;
            $totalOrderAmount += $totalAmount;
        }


        $this->deleteCartAfterOrder($cartIds, $cartItemIDs);
        
        DB::commit();

        if($data['payment_method'] == Order::VNPAY){
            return resolve(GetUrlPaymentAction::class)->setParams([
                'total' => $totalOrderAmount,
                'orderIds' => $orderIds,
            ])->handle();
        }
        
        return response()->json([
            'code' => '1',
            'message' => 'create order successfully',
            'susscess' => true
        ], 200);
    }

    public function createOrderGHN($dataInfoUserBuy, $weight, $shopId, $items, $paymentMethod, $totalAmount)
    {
        $data = [
            'to_name' => $dataInfoUserBuy['to_name'],
            'to_phone' => $dataInfoUserBuy['to_phone'],
            'to_address' => $dataInfoUserBuy['to_address'],
            'to_ward_code' => $dataInfoUserBuy['to_ward_code'],
            'to_district_id' => $dataInfoUserBuy['to_district_id'],
            'weight' => $weight,
            'length' => 10,
            'width' => 10,
            'height' => 10,
            'service_type_id' => 2,
            'required_note' => 'CHOXEMHANGKHONGTHU',
            'payment_type_id' => $paymentMethod == Order::CASH_ON_DELIVERY ? 2 : 1,
            'items' => $items,
            'total_service' => 0,
            'cod_amount' => $paymentMethod == Order::CASH_ON_DELIVERY ? $totalAmount : 0,
        ];
        
        $response = Http::withHeaders([
            'Token' => config('ghn.token'),
            'ShopId' => $shopId,
            'Content-Type' => 'application/json',
        ])
        ->post(config('ghn.api.create_order'), $data); 

        return $response->json();
    }

    public function getItemOrder($cartItems)
    {
        foreach ($cartItems->toArray() as $value) {
            $orderData[] = [
                'id' => $value['product']['id'],
                'name' => $value['product']['name'],
                'quantity' => $value['quantity'],
                'weight' => $value['product']['weight'],
                'code' => $value['code'] ?? "",
                'length' => 10,
                'width' => 10,
                'height' => 10,
                'convert_weight' => 200,
                'calculate_weight' => 300,
                'cod_amount' => 0,
            ];
        }

        return $orderData;
    }

    public function getShopIdGHN($shopId)
    {
        return Shop::where('id', $shopId)->first()->shop_id;
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

    public function calculateDiscount($vouchers, $voucherId, $totalAmount)
    {
        $voucher = $vouchers->where('id', $voucherId)->where('end_at', '>=', date('Y-m-d'))->first();

        if($voucher) {
            if($totalAmount >= $voucher->min_price) {
                $reductionPrice = $this->calcReduction($totalAmount, $voucher);
                $totalAmount = $totalAmount - $reductionPrice;
                return [$totalAmount, $reductionPrice, $voucher];
            }
            throw ValidationException::withMessages(['code_message_value' => 'Giá trị đơn hàng nhỏ hơn giá tối thiểu được áp dụng mã giảm giá này!']);
        } else {
            throw ValidationException::withMessages(['voucher_invalid' => 'Mã giảm giá mà bạn áp dụng không tồn tại hoặc đã hết hạn!']);
        }
        
    }

    public function deleteCartAfterOrder($cartIds, $cartItemIDs)
    {   
        $this->cartItemRepository->whereIn('id', $cartItemIDs)->delete();

        foreach ($cartIds as $key => $cartId) {
            $checkExist = $this->cartItemRepository->where(['cart_id' => $cartId])->first();
            
            if(is_null($checkExist)){
                Cart::where('id', $cartId)->delete();
            }
        }
    }

    public function decreaseProductAfterOrder($cartItems)
    {
        foreach ($cartItems->toArray() as $value) {
            $this->productRepository->where(['id' => $value['product']['id']])
                ->update(['quantity' => $value['product']['quantity'] -  $value['quantity']]);
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
