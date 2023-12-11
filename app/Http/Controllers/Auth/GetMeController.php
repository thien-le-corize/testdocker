<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use App\Http\Requests\Auth\GetMeRequest;
use App\Models\CartItem;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class GetMeController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param GetMeRequest $request
     * @return mixed
     */
    public function __invoke(GetMeRequest $request)
    {
        $user = auth()->user();
        
        $carts = $user->carts;

        $userInfo = [
            'name' => optional($user)->getAttribute('name'),
            'role' => optional($user)->getRelationValue('role'),
            'email' => optional($user)->getAttribute('email'),
            'addresses' => optional($user)->getRelationValue('addresses'),
            'shop' => optional($user)->getRelationValue('shop'),
            'wish_list_ids' => optional($user)->wishlist_product_ids,
            'cartCount' => $this->getCartCount($carts)
        ];


        return $userInfo;
    }

    public function getCartCount($carts)
    {
        $cartIds = [];
        foreach ($carts as $cart) {
            $cartIds[] = $cart->id;
        }

        return CartItem::whereIn('cart_id', $cartIds)->count();
    }
}
