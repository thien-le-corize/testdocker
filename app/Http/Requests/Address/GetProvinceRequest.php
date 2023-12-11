<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class GetProvinceRequest extends FormRequest
{
    /**
     * Determine if the  is authorized to make this request.
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
            // 'Token' => 'required|string',
        ];
    }
}
