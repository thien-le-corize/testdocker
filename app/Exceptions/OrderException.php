<?php

namespace App\Exceptions;

use App\Exceptions\BaseException;

class OrderException extends BaseException
{
    public static function voucherInvalid()
    {
        return self::code('errors.voucher_invalid');
    }

    public static function orderNotReivew()
    {
        return self::code('errors.order_not_review');
    }
}
