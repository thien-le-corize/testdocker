<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class GetShoppingFeeRequest extends FormRequest
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
            'address_id' => 'required|integer',
            'voucher_shoppe_id' => 'nullable|integer',
            'data_order.*.shop_id' => 'nullable|integer|exists:shops,id',
            'data_order.*.cart_item_ids' => 'required',
            'data_order.*.cart_item_ids.*' => 'required|integer|exists:cart_items,id',
            'data_order.*.voucher_id' => 'nullable|integer|exists:vouchers,id',
        ];
    }
}
