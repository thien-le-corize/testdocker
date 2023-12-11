<?php

namespace App\Http\Actions\Cart;

use App\Helpers\Common;
use Illuminate\Support\Facades\DB;
use App\Http\Tasks\Cart\GetCartTask;
use App\Repositories\CartRepository;
use App\Http\Shared\Actions\BaseAction;
use App\Repositories\ProductRepository;
use App\Repositories\CartItemRepository;
use App\Exceptions\AuthenticateException;
use App\Exceptions\Exception;

class GetCartAction extends BaseAction
{

    protected $cartItemRepository;

    protected $cartRepository;


    public function __construct
    (
        CartRepository $cartRepository,
        ProductRepository $cartItemRepository
    )
    {
        $this->cartRepository = $cartRepository;
        $this->cartItemRepository = $cartItemRepository;
    }

    /**
     * @return \Illuminate\Support\Collection|mixed
     * @throws \Exception
     */
    public function handle()
    {
        $carts = auth()->user()->carts;
        if($carts->isEmpty()){
            return [];
        }
        return resolve(GetCartTask::class)->handle($carts);
    }
}
