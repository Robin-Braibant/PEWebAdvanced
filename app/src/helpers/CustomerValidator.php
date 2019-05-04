<?php namespace App\Helper;

use App\Exception\AuthenticationException;
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
     * @return void
     * @throws AuthenticationException
     */
    function validateRegistry(Customer $customer) {
        $this->validatePossibleRegistryErrors($customer);
    }

    /**
     * @param $customer
     * @return void
     * @throws AuthenticationException
     */
    function validatePossibleRegistryErrors($customer) {
        if ($customer->getPassword() !== $customer->getConfirmPassword()) {
            throw new AuthenticationException("Password wasn't identical to confirm password");
        }
        if ($this->userNameisTooShort($customer->getName())) {
            throw new
                AuthenticationException( "Username should at least be " .
                        CustomerValidator::$MIN_USERNAME_LENGTH . " characters long");
        }
        if ($this->passwordIsTooShort($customer->getPassword())) {
            throw new
                AuthenticationException("Password should at least be " .
                        CustomerValidator::$MIN_PASSWORD_LENGTH . " characters long");
        }

        if ($this->usernameIsTaken($customer)) {
            throw new AuthenticationException("User " . $customer->getName() . " already exists.");
        }
    }

    function userNameisTooShort(String $username) : bool {
        return strlen($username) < CustomerValidator::$MIN_USERNAME_LENGTH;
    }

    function passwordIsTooShort(String $password) : bool {
        return strlen($password) < CustomerValidator::$MIN_PASSWORD_LENGTH;
    }

    /**
     * @param Customer $customer
     * @throws AuthenticationException
     */
    function validateLogin(Customer $customer) {
        $this->validatePossibleLoginErrors($customer);
    }

    /**
     * @throws AuthenticationException
     */
    private function validatePossibleLoginErrors(Customer $customer) {
        if (!$this->customerExists($customer)) {
            throw new AuthenticationException("Username or password was wrong");
        }
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

    /**
     * @param $customer
     * @return void
     * @throws AuthenticationException
     */
    function validatePasswordRecovery($customer) {
        $this->validatePossibleLoginErrors($customer);
        if ($customer->getNewPassword() !== $customer->getConfirmPassword()) {
            throw new AuthenticationException("New password wasn't identical to confirmation password");
        }
    }
}