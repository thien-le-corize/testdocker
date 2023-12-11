<?php

namespace App\Http\Actions\Voucher;

use App\Exceptions\AuthenticateException;
use App\Http\Shared\Actions\BaseAction;
use App\Models\User;
use App\Repositories\VoucherRepository;
use Illuminate\Support\Facades\Auth;

class DeleteVoucherAction extends BaseAction
{
    protected $voucherRepository;

    protected $user;

    /**
    * @var VoucherRepository $voucherRepository
    */
   public function __construct(VoucherRepository $voucherRepository)
   {
       $this->voucherRepository = $voucherRepository;
   }
    
    public function handle()
    {
        $id = $this->params['id'];
        $user = Auth::user();

        $voucher = $this->voucherRepository->find($id);

        if ($user->can('delete', $voucher)) {
            $voucher->delete;
            return $this->setMessage('delete_success', 'voucher',null, null);
        }
    }
}