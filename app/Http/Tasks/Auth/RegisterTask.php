<?php

namespace App\Http\Tasks\Auth;

use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Repositories\ShopRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Http\Tasks\Auth\SendVerifyEmailTask;
use Illuminate\Validation\ValidationException;

class RegisterTask
{
    /**
     * @var UserRepository $userRepository
     */
    protected $userRepository;

    /**
     * @var ShopRepository $shopRepository
     */
    protected $shopRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository, ShopRepository $shopRepository)
    {
        $this->userRepository = $userRepository;
        $this->shopRepository = $shopRepository;
    }

    public function handle($request)
    {
        $dataUser = request(['name', 'email']);
        $dataUser['password'] = Hash::make($request['password']);
        $dataUser['role_id'] = $request['role_id'];
        $dataUser['phone'] = $request['phone'];
        $dataUser['token_verify'] = Str::random(40);

        DB::beginTransaction();
        DB::enableQueryLog();

        // handle case register role seller
        if($dataUser['role_id'] == Role::SELLER){
            $dataUser['shop_id']  = $this->createRoleSeller($dataUser, $request);
        }

        $userId = $this->userRepository->insertGetId($dataUser, false);

        if(!$userId){
            return 'errror';
        }

        $user = $this->userRepository->findByField('id', $userId)->first();
        // logic send email verify user after register account
        resolve(SendVerifyEmailTask::class)->handle($dataUser);

        DB::commit();
        return response()->json([
            'success' => true,
            'message' => 'user registration successfully',
            'user' => $user
        ], 201);
    }

    public function createRoleSeller($dataUser, $request)
    {
        $dataUser['district_id'] = $request['district_id'];
        $dataUser['ward_code'] = $request['ward_code'];
        $dataUser['address'] = $request['address'];
        $dataUser['shop_name'] = $request['shop_name'];

        // get ShopID from GHN
        $dataUser['shop_id'] = $this->createShopToGHN($dataUser);

        return $this->createDataShop($dataUser);  
    }

    public function createDataShop($data)
    {
        $dataInsertShop = [
            'district_id' =>  $data['district_id'],
            'ward_code' => $data['ward_code'],
            'shop_id' => $data['shop_id'],
            'address' => $data['address'],
            'shop_name' => $data['shop_name'],
            'shop_image' => config('common.uploads.default_shop_image')
        ];

        return $this->shopRepository->insertGetId($dataInsertShop, false);
    }

    public function createShopToGHN($data)
    {
        $dataInsertShop = [
            'district_id' =>  $data['district_id'],
            'ward_code' => $data['ward_code'],
            'name' => $data['shop_name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
        ];

        $dataShop = Http::withHeaders([
            'Token' => config('ghn.token'),
            'Content-Type' => 'application/json',
        ])->post(config('ghn.api.create_shop'), $dataInsertShop);

        $data = json_decode($dataShop, true);
        if(!empty($data['code_message']) && $data['code_message'] == 'PHONE_INVALID'){
            throw ValidationException::withMessages(['code_message_value' => 'So dien thoai khong hop le. Vui long thu lai sau']);
        }
        return $data['data']['shop_id'];
    }
}
