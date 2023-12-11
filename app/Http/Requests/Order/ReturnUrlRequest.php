<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class ReturnUrlRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'vnp_Amount' => 'string',
            'vnp_BankCode' => 'string',
            'vnp_BankTranNo' => 'string',
            'vnp_CardType' => 'string',
            'vnp_OrderInfo' => 'string',
            'vnp_PayDate' => 'string',
            'vnp_ResponseCode' => 'string',
            'vnp_TmnCode' => 'string',
            'vnp_TransactionNo' => 'string',
            'vnp_TransactionStatus' => 'string',
            'vnp_TxnRef' => 'string',
            'vnp_SecureHash' => 'string',
        ];
    }
}

