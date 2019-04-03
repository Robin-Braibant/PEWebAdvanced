<?php namespace App\Helper;

use App\Model\AuthenticationAttempt;
use App\Model\Customer;

class CustomerValidator
{
    private static $MIN_USERNAME_LENGTH = 6;
    private static $MIN_PASSWORD_LENGTH = 8;

    private $entityManager;

    public function __construct($container) {
        $this->entityManager = $container->get('em');
    }

    /**
     * @param Customer $customer
     * @return AuthenticationAttempt
     */
    function validate(Customer $customer) {
        $errorAuthenticationAttempt = $this->validatePossibleErrors($customer);

        return $errorAuthenticationAttempt ?
            $errorAuthenticationAttempt : $this->createSuccesfulAuthenticationAttempt();
    }

    /**
     * @param $customer
     * @return AuthenticationAttempt|null
     */
    function validatePossibleErrors($customer) {
        if ($customer->getPassword() !== $customer->getConfirmPassword()) {
            return $this->createFailedAuthenticationAttemptWithMessage( "Password wasn't identical to confirm password");
        }
        if ($this->userNameisTooShort($customer->getName())) {
            return $this->createFailedAuthenticationAttemptWithMessage
            ( "Username should at least be " . CustomerValidator::$MIN_USERNAME_LENGTH . " characters long");
        }
        if ($this->passwordIsTooShort($customer->getPassword())) {
            return $this->createFailedAuthenticationAttemptWithMessage(
                "Password should at least be " . CustomerValidator::$MIN_PASSWORD_LENGTH . " characters long");
        }

        if ($this->customerAlreadyExists($customer)) {
            return $this->createFailedAuthenticationAttemptWithMessage
            ("User " . $customer->getName() . " already exists.");
        }

        return null;
    }

    function userNameisTooShort(String $username) {
        return strlen($username) < CustomerValidator::$MIN_USERNAME_LENGTH;
    }

    function passwordIsTooShort(String $password) {
        return strlen($password) < CustomerValidator::$MIN_PASSWORD_LENGTH;
    }

    function createFailedAuthenticationAttemptWithMessage($message) {
        $authenticationAttempt = new AuthenticationAttempt();

        $authenticationAttempt->setErrorMessage($message);
        $authenticationAttempt->setWasSuccesful(false);

        return $authenticationAttempt;
    }

    function createSuccesfulAuthenticationAttempt() {
        $authenticationAttempt = new AuthenticationAttempt();
        $authenticationAttempt->setWasSuccesful(true);
        return $authenticationAttempt;
    }

    /**
     * @param Customer $customer
     * @return bool
     */
    function customerAlreadyExists($customer) {
        $result = $this->entityManager
            ->getRepository('App\Model\Customer')
            ->findBy(array('name' => $customer->getName()));
        return sizeof($result) >= 1;
    }
}