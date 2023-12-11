<?php

namespace App\Http\Actions\Voucher;

use App\Http\Shared\Actions\BaseAction;
use App\Repositories\VoucherRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateVoucherAction extends BaseAction
{
    protected $voucherRepository;

     /**
     * @var VoucherRepository $voucherRepository
     */
    public function __construct(VoucherRepository $voucherRepository)
    {
        $this->voucherRepository = $voucherRepository;
    }
    
    public function handle()
    {
        DB::beginTransaction();
        try {
            $authUser = Auth::user();
            $userId = $authUser->id;
            $this->request['user_id'] = $userId;
            $this->request['shop_id'] = $authUser->shop_id;
            $this->voucherRepository->upsert([$this->request->all()], false, ['id']);
            $vourcher = $this->voucherRepository->find($this->request['id']);
            DB::commit();
            return $vourcher;
        } catch(\Exception $e) {
            DB::rollback();
            return $e;
        }
    }
}