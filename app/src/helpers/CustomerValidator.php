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
    function validateRegistry(Customer $customer) : AuthenticationAttempt {
        $errorAuthenticationAttempt = $this->validatePossibleRegistryErrors($customer);

        return $errorAuthenticationAttempt ?
            $errorAuthenticationAttempt : $this->createSuccessfulAuthenticationAttempt();
    }

    /**
     * @param $customer
     * @return AuthenticationAttempt|null
     */
    function validatePossibleRegistryErrors($customer) {
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

        if ($this->usernameIsTaken($customer)) {
            return $this->createFailedAuthenticationAttemptWithMessage
            ("User " . $customer->getName() . " already exists.");
        }

        return null;
    }

    function userNameisTooShort(String $username) : bool {
        return strlen($username) < CustomerValidator::$MIN_USERNAME_LENGTH;
    }

    function passwordIsTooShort(String $password) : bool {
        return strlen($password) < CustomerValidator::$MIN_PASSWORD_LENGTH;
    }

    /**
     * @param Customer $customer
     * @return AuthenticationAttempt
     */
    function validateLogin(Customer $customer) : AuthenticationAttempt {
        $errorAuthenticationAttempt = $this->validatePossibleLoginErrors($customer);

        return $errorAuthenticationAttempt ?
            $errorAuthenticationAttempt : $this->createSuccessfulAuthenticationAttempt();
    }

    private function validatePossibleLoginErrors(Customer $customer) : AuthenticationAttempt {
        if (!$this->customerExists($customer)) {
            return $this
                ->createFailedAuthenticationAttemptWithMessage("Username or password was wrong");
        }

        return $this->createSuccessfulAuthenticationAttempt();
    }

    function createFailedAuthenticationAttemptWithMessage($message) : AuthenticationAttempt {
        $authenticationAttempt = new AuthenticationAttempt();

        $authenticationAttempt->setErrorMessage($message);
        $authenticationAttempt->setWasSuccesful(false);

        return $authenticationAttempt;
    }

    function createSuccessfulAuthenticationAttempt() : AuthenticationAttempt {
        $authenticationAttempt = new AuthenticationAttempt();
        $authenticationAttempt->setWasSuccesful(true);
        return $authenticationAttempt;
    }

    function customerExists(Customer $customer) : bool {
        $credentialsProperties = [
            'name' => $customer->getName(),
            'password' => $customer->getPassword()
        ];
        return $this->customerWithPropertiesExists($credentialsProperties);
    }

    /**
     * @param Customer $customer
     * @return bool
     */
    function usernameIsTaken(Customer $customer) : bool {
        $userNameProperty = array('name' => $customer->getName());
        return $this->customerWithPropertiesExists($userNameProperty);
    }

    function customerWithPropertiesExists($properties) : bool {
        $result = $this->entityManager
            ->getRepository('App\Model\Customer')
            ->findBy($properties);
        return sizeof($result) >= 1;
    }
}