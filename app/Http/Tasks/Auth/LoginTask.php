<?php

namespace App\Http\Tasks\Auth;


use Tymon\JWTAuth\Facades\JWTAuth;
use App\Repositories\UserRepository;
use App\Exceptions\AuthenticateException;
use Illuminate\Validation\ValidationException;

class LoginTask
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
    public function handle()
    {
        $credentials = request(['email', 'password']);

        $user = $this->userRepository
            ->where([
                'email' => $credentials['email']
            ])
            ->first();

        if (!$user) {
            throw AuthenticateException::userNotFound();
        }

        $user = $this->userRepository
            ->where([
                'isValid' => true,
                'email' => $credentials['email']
            ])
            ->first();

        if (!$user) {
            throw AuthenticateException::invalidEmailConfirm();
        }

        $token = $this->handleLogin($credentials);

        $userInfo = [
            'role' => $user->getRelationValue('role'),
            'email' => $user->getAttribute('email'),
            'name' => $user->getAttribute('name'),
        ];

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 25200,
            'user' => $userInfo
        ]);
    }

    /**
     * @param array $credentials
     * @return string
     */
    protected function handleLogin($credentials)
    {
        $token = auth()->attempt($credentials);
        if (!$token) {
            throw AuthenticateException::invalidCredentials();
        }
        return $token;
    }
}
