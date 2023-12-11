<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Voucher;
use Illuminate\Auth\Access\HandlesAuthorization;

class VoucherPolicy
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
        public function delete(User $user, Voucher $voucher)
        {
            return $user->id === $voucher->user_id;
        }
}
