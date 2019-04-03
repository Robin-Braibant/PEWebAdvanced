<?php namespace App\Controller;
/**
 * Created by PhpStorm.
 * User: mcoppieters
 * Date: 03/04/19
 * Time: 17:22
 */

namespace App\Model;


class AuthenticationAttempt
{
    private $wasSuccesful;
    private $errorMessage;

    /**
     * @return mixed
     */
    public function getWasSuccesful()
    {
        return $this->wasSuccesful;
    }

    /**
     * @return mixed
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @param mixed $wasSuccesful
     */
    public function setWasSuccesful($wasSuccesful): void
    {
        $this->wasSuccesful = $wasSuccesful;
    }

    /**
     * @param mixed $errorMessage
     */
    public function setErrorMessage($errorMessage): void
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return bool
     */
    public function hasPasswordError(): bool {
        return strpos(strtolower($this->errorMessage), 'password') !== false;
    }
}