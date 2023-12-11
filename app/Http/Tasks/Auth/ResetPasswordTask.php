<?php

namespace App\Http\Tasks\Auth;

use Carbon\Carbon;
use App\Models\PasswordReset;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Exceptions\AuthenticateException;
use Illuminate\Validation\ValidationException;

class ResetPasswordTask
{
    /**
     * @var UserRepository $userRepository
     */
    protected $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param \Illuminate\Support\Collection $request
     * @return array|mixed|string[]
     * @throws ValidationException
     * @throws \App\Exceptions\BaseException
     */
    public function handle($request)
    {
        $data = $request->all();
        try {
            $data['email'] = Crypt::decryptString($data['email']);
        } catch (\Exception $e) {
            throw AuthenticateException::invalidTokenExpired();
        }

        $passwordReset = PasswordReset::where('token', $data['token'])->first();

        if (!$passwordReset) {
            throw AuthenticateException::invalidToken();
        }

        if (Carbon::parse($passwordReset->updated_at)->addHours(24)->isPast()) {
            $passwordReset->delete();
            throw AuthenticateException::invalidTokenExpired();
        }
        $user = $this->userRepository->where(['email' => $passwordReset->email])->firstOrFail();
        $user->update(['password' => Hash::make($data['password'])]);
        $passwordReset->delete();
        return ['message' => 'Password has been successfully changed'];
    }
}
