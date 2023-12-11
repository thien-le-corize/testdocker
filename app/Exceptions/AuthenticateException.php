<?php

namespace App\Exceptions;

use App\Exceptions\BaseException;

class AuthenticateException extends BaseException
{
    public static function invalidCredentials()
    {
        return self::code('errors.login_info');
    }

    public static function invalidApiKey()
    {
        return self::code('errors.api_key');
    }

    public static function accountLocked()
    {
        return self::code('errors.account_locked');
    }

    public static function updatePasswordFail()
    {
        return self::code('errors.update_pw_fail');
    }

    public static function invalidStatus()
    {
        return self::code('errors.invalid_status');
    }

    public static function invalidDecryptEmail()
    {
        return self::code('errors.email_decrypt_invalid');
    }

    public static function invalidToken()
    {
        return self::code('errors.token_does_not_exist');
    }

    public static function invalidTokenExpired()
    {
        return self::code('errors.token_expired')->setMessageCode('401');
    }

    public static function forbidden()
    {
        return self::code('errors.forbidden')->setMessageCode('403');
    }

    public static function limitLogin()
    {
        return self::code('errors.limit_login')->setMessageCode('403');
    }

    public static function userNotFound()
    {
        return self::code('errors.user_not_found_with_email');
    }

    public static function invalidEmailConfirm()
    {
        return self::code('errors.invalid_email_comfirm');
    }

    public static function recordNotFound()
    {
        return self::code('errors.record_not_found');
    }
}
