<?php

namespace App\Http\Actions\ShopeeVoucher;

use App\Http\Shared\Actions\BaseAction;
use App\Repositories\ShopeeVoucherRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateShopeeVoucherAction extends BaseAction
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
            $idVourcher = $this->ShopeeVoucherRepository->insertGetId($this->request->all(), false);
            $vourcher = $this->ShopeeVoucherRepository->find($idVourcher);
            DB::commit();
            return $vourcher;
        } catch(\Exception $e) {
            DB::rollback();
            return $e;
        }
        
    }
}