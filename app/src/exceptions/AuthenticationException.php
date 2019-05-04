<?php namespace App\Exception;
/**
 * Created by PhpStorm.
 * User: mcoppieters
 * Date: 03/04/19
 * Time: 17:22
 */

use Exception;

class AuthenticationException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return bool
     */
    public function hasPasswordError(): bool {
        return strpos(strtolower($this->message), 'password') !== false;
    }

    /**
     * @return bool
     */
    public function hasDifferentPasswordError(): bool {
        return strpos(strtolower($this->message), 'identical') !== false;
    }
}