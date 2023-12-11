<?php

namespace App\Http\Requests\Product;

use App\Http\Shared\Requests\RequestHelper;
use Illuminate\Foundation\Http\FormRequest;

class ListProductRequest extends FormRequest
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
        return array_merge(RequestHelper::commonListRules(), [
            'product_ids' => 'nullable',
            'product_ids.*' => 'nullable|integer|exists:products,id',
            'user_id' => 'nullable|integer|exists:users,id',
            'category_id' => 'nullable|integer|exists:categories,id',
            'weight' => 'nullable',
            'name' => 'nullable',
            'price' => 'nullable',
            'min_price' => 'nullable',
            'max_price' => 'nullable',
            'star' => 'nullable',
        ]);
    }
}
