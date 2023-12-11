<?php

namespace App\Http\Actions\Auth;

use App\Http\Shared\Actions\BaseAction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\AuthenticateException;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;
class ChangePasswordAction extends BaseAction
{
    public function handle()
    {
        $data = $this->request->all();
        $account = Auth::user();

        if (!Hash::check($data['current_password'], $account->password)) {
            throw AuthenticateException::updatePasswordFail();
        }

        $account->password = Hash::make($data['password']);
        $account->updated_at = Carbon::now();

        $account->save();
        return [
            'message' => Lang::get('success.auth.change_password_success'),
            'data' => $account
        ];
    }
}
