<?php

namespace App\Http\Requests\Shop;

use App\Helpers\Common;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class ListShopRequest extends FormRequest
{
    /**
     * Determine if the  is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        // return Common::checkRoleAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'Token' => 'required|string',
        ];
    }
}
