<?php

namespace App\Http\Actions\ShopeeVoucher;

use App\Http\Shared\Actions\BaseAction;
use App\Repositories\ShopeeVoucherRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateShopeeVoucherAction extends BaseAction
{
    protected $ShopeeVoucherRepository;

     /**
     * @var ShopeeVoucherRepository $ShopeeVoucherRepository
     */
    public function __construct(ShopeeVoucherRepository $ShopeeVoucherRepository)
    {
        $this->ShopeeVoucherRepository = $ShopeeVoucherRepository;
    }
    
    public function handle()
    {
        DB::beginTransaction();
        try {
            $authUser = Auth::user();
            $userId = $authUser->id;
            $this->request['user_id'] = $userId;
            $this->ShopeeVoucherRepository->upsert([$this->request->all()], false, ['id']);
            $voucher = $this->ShopeeVoucherRepository->find($this->request['id']);
            DB::commit();
            return $voucher;
        } catch(\Exception $e) {
            DB::rollback();
            return $e;
        }
    }
}