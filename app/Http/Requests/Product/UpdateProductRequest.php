<?php

namespace App\Http\Requests\Product;

use App\Helpers\Common;
use App\Models\Role;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $shopId = Product::find($this->get('id'))->first()->shop_id;
        $user = auth()->user();
        if(optional($user)->getRelationValue('role')->name ==  Role::ROLE_ADMIN || $shopId == $user->shop->id){
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $productId = $this->get('id');
        $shopId = Product::where('id', $productId)->first()->shop_id;
        $status = Common::getStatusProductByRole();
        return [
            'id' => 'required|integer|exists:products,id',
            'name' => "nullable|unique:products,name,$productId,id,shop_id,$shopId",
            'description' => 'nullable|string|min:20',
            'images' => 'nullable',
            'images.*' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'videos.' => 'nullable|image',
            'weight' => 'nullable|integer',
            'category_id' => 'nullable|integer|exists:categories,id',
            'attributes' => 'nullable|json',
            'demension' => 'nullable|json',
            'quantity' => 'nullable|integer',
            'status' => 'nullable|in:'. implode(',', array_keys($status)),
        ];
    }
}
