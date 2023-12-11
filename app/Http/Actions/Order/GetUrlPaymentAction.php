<?php

namespace App\Http\Actions\Order;

use App\Http\Shared\Actions\BaseAction;

class GetUrlPaymentAction extends BaseAction
{
    public function handle()
    {
        $totalAmount = $this->params['total'];
        $orderIds = $this->params['orderIds'];
        $vnp_Url = config('common.vnp.vnp_Url');
        $vnp_Returnurl = config('common.user_site_url') . '/order/verify';
        $vnp_HashSecret = config('common.vnp.vnp_HashSecret');
        $inputData = [
            "vnp_Version" => "2.1.0",
            'vnp_Command' => 'pay',
            'vnp_TmnCode' =>  config('common.vnp.vnp_TmnCode'),
            'vnp_Amount' => $totalAmount * 100,
            'vnp_BankCode' => 'NCB',
            'vnp_CreateDate' => date('YmdHis'),
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => \Request::ip(),
            'vnp_Locale' => 'vn',
            'vnp_OrderInfo' => json_encode($orderIds),
            'vnp_OrderType' =>  'order',
            'vnp_ReturnUrl' => $vnp_Returnurl,
            'vnp_TxnRef' => $this->generateRandomAlphanumeric(),
        ];

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }
        
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//   
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        $returnData = [
            'code' => '2', 
            'message' => 'success', 
            'redirect' => $vnp_Url
        ];

        return json_decode(json_encode($returnData));
    }


    public function generateRandomAlphanumeric() {
        $currentDateTime = date('Y-m-d H:i:s');

        $randomString = md5($currentDateTime);
    
        return $randomString;
    }

}
