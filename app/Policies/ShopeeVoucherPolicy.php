<?php

namespace App\Policies;

use App\Models\ShopeeVoucher;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShopeeVoucherPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the given post can be deleted by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Voucher  $voucher
     * @return bool
     */
    public function delete(User $user, ShopeeVoucher $shopeeVoucher)
    {
        return $user->id === $shopeeVoucher->user_id;
    }
}
