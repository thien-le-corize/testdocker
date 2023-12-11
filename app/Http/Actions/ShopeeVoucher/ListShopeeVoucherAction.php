<?php

namespace App\Http\Actions\ShopeeVoucher;

use App\Http\Shared\Actions\BaseAction;
use App\Models\Role;
use App\Models\User;
use App\Repositories\ShopeeVoucherRepository;
use Illuminate\Support\Facades\Auth;

class ListShopeeVoucherAction extends BaseAction
{
    protected $ShopeeVoucherRepository;

    public function __construct(ShopeeVoucherRepository $ShopeeVoucherRepository)
    {
        $this->ShopeeVoucherRepository = $ShopeeVoucherRepository;
    }
    
    public function handle()
    {
        $query = $this->ShopeeVoucherRepository;
        $shopId = auth()->user()->shop_id;
        if(Auth::user()->role ==Role::ROLE_ADMIN) {
            $this->ShopeeVoucherRepository->where(['shop_id' => $shopId]);
        }
        if(Auth::user()->role == Role::ROLE_USER) {
            return $query->get();
        }
        return $query->paginate(15);
    }
}