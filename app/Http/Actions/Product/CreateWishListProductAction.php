<?php

namespace App\Http\Actions\Product;

use App\Models\User;
use App\Helpers\Common;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;
use App\Http\Shared\Actions\BaseAction;
use App\Repositories\ProductRepository;
use App\Exceptions\AuthenticateException;
use App\Http\Tasks\Product\CreateProductTask;

class CreateWishListProductAction extends BaseAction
{

    protected $productRepository;
    protected $userRepository;

    public function __construct(ProductRepository $productRepository, UserRepository $userRepository)
    {
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @return \Illuminate\Support\Collection|mixed
     * @throws \Exception
     */
    public function handle()
    {
        $productId = $this->request['product_id'] ;

        $user = $this->userRepository->where(['id' => auth()->user()->id])->first();

        $isCheckExists = $user->whereRaw("$productId = ANY(wishlist_product_ids)")->first();
        
        // WORK
        is_null($isCheckExists)  
                ? $this->userRepository->where(['id' => auth()->user()->id])->update([
                    'wishlist_product_ids' => DB::raw("array_append(wishlist_product_ids, $productId)")
                ])
        
                : $this->userRepository->where(['id' => auth()->user()->id])->update([
                    'wishlist_product_ids' => DB::raw("array_remove(wishlist_product_ids, $productId)")
                ]);

        // NO WORK
        // $result = is_null($isCheckExists)  
        //     ? $user->update(['wishlist_product_ids' => DB::raw("array_append(wishlist_product_ids, $productId)")])
        //     : $user->update(['wishlist_product_ids' => DB::raw("array_remove(wishlist_product_ids, $productId)")]);

        // dd($result);
        return $this->setMessage('create_success', 'product_wishlist', null, null);
    }
}
