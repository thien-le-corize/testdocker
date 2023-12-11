<?php

namespace App\Http\Requests\User;

use App\Models\Role;
use App\Helpers\Common;
use Illuminate\Foundation\Http\FormRequest;

class DeleteUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Common::checkRoleAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            // 'id' => 'required|integer|exists:users,id',
        ];
    }
}
