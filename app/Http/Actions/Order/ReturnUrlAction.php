<?php

namespace App\Http\Actions\Order;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Repositories\OrderRepository;
use App\Http\Shared\Actions\BaseAction;
use App\Repositories\PaymentRepository;
use App\Repositories\ProductRepository;
use App\Repositories\OrderProductRepository;

class ReturnUrlAction extends BaseAction
{
    protected $paymentRepository;
    protected $orderRepository;
    protected $orderProductRepository;
    protected $productRepository;

    public function __construct
    (
        PaymentRepository $paymentRepository,
        OrderRepository $orderRepository,
        OrderProductRepository $orderProductRepository,
        ProductRepository $productRepository,
    )
    {
        $this->paymentRepository = $paymentRepository;
        $this->orderRepository = $orderRepository;
        $this->orderProductRepository = $orderProductRepository;
        $this->productRepository = $productRepository;
    }

    public function handle()
    {
        $data = $this->request->all();
        $inputData = array();
        $returnData = array();
        
        foreach ($data as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, config('common.vnp.vnp_HashSecret'));
        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        $vnp_Amount = $inputData['vnp_Amount']/100; // Số tiền thanh toán VNPAY phản hồi
        $Status = 0; // Là trạng thái thanh toán của giao dịch chưa có IPN lưu tại hệ thống của merchant chiều khởi tạo 
        $orderId = $inputData['vnp_TxnRef'];

        $orderIds = json_decode($inputData['vnp_OrderInfo']);
        $orders = $this->orderRepository->where([
            'user_id' => auth()->user()->id
        ])->whereIn('id', $orderIds)->get();

            
        $totalAmountOrder = collect($orders)->sum('total_amount');

        foreach ($orders as $order) {
            try {
                if ($secureHash == $vnp_SecureHash) {

                    if ($order != NULL) {
                        if($totalAmountOrder == $vnp_Amount) {
                            $statusOrder = $order->status[0];

                            if ($statusOrder != NULL && $statusOrder == Order::PENDING) {
                                $Status = $inputData['vnp_ResponseCode'] == '00' || $inputData['vnp_TransactionStatus'] == '00' ? 1 : 2;
                                $returnData['RspCode'] = '00';
                                $returnData['Message'] = 'Confirm Success';
                            } else {
                                $returnData['RspCode'] = '02';
                                $returnData['Message'] = 'Order already confirmed';
                            }
                        } else {
                            $returnData['RspCode'] = '04';
                            $returnData['Message'] = 'invalid amount';
                        }
                    } else {
                        $returnData['RspCode'] = '01';
                        $returnData['Message'] = 'Order not found';
                    }
                } else {
                    $returnData['RspCode'] = '97';
                    $returnData['Message'] = 'Invalid signature';
                }
            } catch (\Exception $e) {
                $returnData['RspCode'] = '99';
                $returnData['Message'] = 'Unknow error';
            }

            $dataPaymentInfo = [
                'order_id' => $order->id,
                'amount' => $totalAmountOrder,
                'bank_code' => $vnp_BankCode,
                'transaction_no' => $vnpTranId,
                'card_type' => $inputData['vnp_CardType'],
                'order_info' => $inputData['vnp_OrderInfo'],
                'transaction_code' =>  $returnData['RspCode'],
                'TxnRef' =>  $inputData['vnp_TxnRef'],
            ];

            $order->update([
                'payment_info' => json_encode($dataPaymentInfo, true),
            ]);
            // neu thanh toan thanh thi update table order
            // nguoc lai neu thanh toan that bai thi rollback data da order
            if($Status == 1){

                $order->update([
                    // 'status' => DB::raw("array_append(status, 2)"),
                    // 'status' => DB::raw("'{" . Order::TOSHIP . "}'"),
                    'payment_status' => true
                ]);
            }else{

                $orderProduct = $order->first()->orderProducts;
                $this->rollBackProduct($orderProduct);
            }
        }

        return json_decode(json_encode($returnData));
    }

    public function rollBackProduct($data)
    {
        foreach ($data->toArray() as $value) {
            $product = $this->productRepository->where(['id' => $value['product_id']])->first();
            $product->update(['quantity' => $product->quantity +  $value['quantity']]);
        }
    }

}
