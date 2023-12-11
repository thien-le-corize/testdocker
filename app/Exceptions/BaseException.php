<?php

namespace App\Exceptions;

use Exception;

class BaseException extends Exception
{
    /**
     * @var int
     */
    protected $code = 400;

    /**
     * @var string
     */
    protected $messageCode = null;

    /**
     * Set the message code
     *
     * @param string $code
     * @return self
     */
    public function setMessageCode(string $code)
    {
        $this->messageCode = $code;

        return $this;
    }

    /**
     * Get the message code
     *
     * @return string
     */
    public function getMessageCode()
    {
        return $this->messageCode;
    }

    /**
     * Create new exception instance with code
     *
     * @return self
     */
    public static function code($code, $args = [], $statusCode = 400)
    {
        return (new self(__($code, $args), $statusCode))->setMessageCode($code);
    }

    /**
     * Create new exception instance with message
     *
     * @return self
     */
    public static function exceptionWithMessage($code, $args = [], $statusCode = 400, $messageCode = '')
    {
        return (new self(__($code, $args), $statusCode))->setMessageCode($messageCode);
    }
}
