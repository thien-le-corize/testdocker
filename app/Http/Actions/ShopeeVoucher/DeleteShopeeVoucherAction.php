<?php

namespace App\Http\Actions\ShopeeVoucher;

use App\Exceptions\AuthenticateException;
use App\Http\Shared\Actions\BaseAction;
use App\Models\User;
use App\Repositories\ShopeeVoucherRepository;
use Illuminate\Support\Facades\Auth;

class DeleteShopeeVoucherAction extends BaseAction
{
    protected $ShopeeVoucherRepository;

    protected $user;

    /**
    * @var ShopeeVoucherRepository $ShopeeVoucherRepository
    */
   public function __construct(ShopeeVoucherRepository $ShopeeVoucherRepository)
   {
       $this->ShopeeVoucherRepository = $ShopeeVoucherRepository;
   }
    
    public function handle()
    {
        $id = $this->params['id'];
        $user = Auth::user();

        $ShopeeVoucher = $this->ShopeeVoucherRepository->find($id);

        if ($user->can('delete', $ShopeeVoucher)) {
            $ShopeeVoucher->delete;
            return $this->setMessage('delete_success', 'Shopee_voucher',null, null);
        }
    }
}