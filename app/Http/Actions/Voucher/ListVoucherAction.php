<?php

namespace App\Http\Actions\Voucher;

use App\Http\Shared\Actions\BaseAction;
use App\Models\Role;
use App\Repositories\VoucherRepository;
use Illuminate\Support\Facades\Auth;

class ListVoucherAction extends BaseAction
{
    protected $voucherRepository;

    public function __construct(VoucherRepository $voucherRepository)
    {
        $this->voucherRepository = $voucherRepository;
    }
    
    public function handle()
    {
        $query = $this->voucherRepository;

        if(Auth::user()->role == Role::ROLE_SELLER) {
            $query->where(['user_id' => Auth::id()]);
        }
        
        if(Auth::user()->role == Role::ROLE_USER) {
            return $query->get();
        }
        return $query->paginate(15);
    }
}