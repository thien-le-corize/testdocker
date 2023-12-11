<?php

namespace App\Http\Requests\Auth;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'string|required|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:20|confirmed',
            'role_id' => 'required|integer|in:2,3',
            'phone' => 'string|required|unique:users',
            'district_id' => $this->input('role_id') == Role::SELLER ? 'required|integer' : 'nullable',
            'ward_code' => $this->input('role_id') == Role::SELLER ? 'required|string' : 'nullable',
            'address' => $this->input('role_id') == Role::SELLER ? 'required|string' : 'nullable',
            'shop_name' => $this->input('role_id') == Role::SELLER ? 'required|string' : 'nullable',
            'shop_image' => $this->input('role_id') == Role::SELLER ? 'nullable|string' : 'nullable',
        ];
    }
}
