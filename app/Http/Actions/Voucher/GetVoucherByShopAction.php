<?php

namespace App\Http\Actions\Voucher;

use App\Http\Shared\Actions\BaseAction;
use App\Models\Voucher;
use App\Repositories\VoucherRepository;

class GetVoucherByShopAction extends BaseAction
{
    protected $voucherRepository;

    public function __construct(VoucherRepository $voucherRepository)
    {
       $this->voucherRepository = $voucherRepository;
    }
    
    public function handle()
    {
        // $ids = $this->request->get('ids');

        // $vouchers = $this->voucherRepository->whereIn('shop_id', $ids )->where('end_at', '>=', date('Y-m-d'))->orderBy('shop_id')->get()->toArray();

        // $voucherByShop = [];
        // foreach ($vouchers as $item) {
        //     $voucherByShop[$item['shop_id']][] = $item;
        // }
        // return $voucherByShop;
        $shopId = $this->params['shopId'];
    
        $vouchers = $this->voucherRepository->where(['shop_id' => $shopId ])->where('end_at', '>=', date('Y-m-d'))->orderBy('shop_id')->get()->toArray();
        return $vouchers;
    }
}