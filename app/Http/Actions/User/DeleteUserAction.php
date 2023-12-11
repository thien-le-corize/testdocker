<?php

namespace App\Http\Actions\user;

use App\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Repositories\ShopRepository;
use App\Repositories\UserRepository;
use App\Repositories\CartItemRepository;
use App\Repositories\CartRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Shared\Actions\BaseAction;
use App\Repositories\ProductRepository;
use App\Exceptions\AuthenticateException;
use App\Repositories\Criteria\OrderCriteria;
use Illuminate\Validation\ValidationException;
use App\Repositories\Criteria\WithRelationCriteria;

class DeleteUserAction extends BaseAction
{
    protected $userRepository;
    protected $shopRepository;
    protected $productRepository;
    protected $cartItemRepository;
    protected $cartRepository;

    public function __construct
    (
        UserRepository $userRepository, 
        ShopRepository $shopRepository,
        ProductRepository $productRepository, 
        CartItemRepository $cartItemRepository,
        CartRepository $cartRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->shopRepository = $shopRepository;
        $this->productRepository = $productRepository;
        $this->cartItemRepository = $cartItemRepository;
        $this->cartRepository = $cartRepository;
    }
    
    public function handle()
    {
        DB::beginTransaction();
        
        $idUserDelete = $this->params['id'];
        $shopId =  $this->userRepository->where(['id' => $idUserDelete])->first()?->shop_id;
        $userAdmin = $this->userRepository->where(['id' => $idUserDelete])->first()->getRelationValue('role')->name == Role::ROLE_ADMIN; 
        if($userAdmin){
            throw ValidationException::withMessages([
               'Forbidden Access to this resource on the server is denied'
            ]);
        }
        if(!is_null($shopId)){
            $this->shopRepository->findOrFail($shopId)->delete();
        }

        $this->userRepository->findOrFail($idUserDelete)->delete();
        
        // if($result){
        //     if(!is_null($shopId)){
        //         $productIds =  $this->productRepository->where(['shop_id' => $shopId])->pluck('id')->toArray();
        //         $this->cartItemRepository->whereIn('product_id', $productIds)->delete();
        //         $this->cartRepository->where(['shop_id' => $shopId])->delete();
        //         $this->productRepository->where(['shop_id' => $shopId])->delete();
        //         $this->shopRepository->findOrFail($shopId)->delete();
        //     }
        // }

        DB::commit();

        return $this->setMessage('delete_success', 'user', null, null);
    }
}