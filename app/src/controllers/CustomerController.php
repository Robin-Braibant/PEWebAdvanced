<?php namespace App\Controller;

/**
 * Created by PhpStorm.
 * User: mcoppieters
 * Date: 02/04/19
 * Time: 10:50
 */

use App\Exception\AuthenticationException;
use App\Model\Customer;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class CustomerController extends BaseController
{
    private $customerValidator;

    public function __construct($container)
    {
        parent::__construct($container);
        $this->customerValidator = $container->get('customerValidator');
    }

    public function dispatchLoginPage(Request $request, Response $response, $args)
    {
        $this->view->render($response, 'index.twig');
        return $response;
    }

    public function login(Request $request, Response $response, $args)
    {
        $formData = $request->getParsedBody();
        $customer = $this->createCustomerFromFormData($formData);

        try {
            $this->customerValidator->validateLogin($customer);

            $response = $response->withStatus(302)->withHeader('Location', '/order');
        } catch (AuthenticationException $e) {
            $this->view->render($response, 'index.twig',
                ['login_error' => $e->getMessage()]);
        }

        return $response;
    }

    public function dispatchRegisterPage(Request $request, Response $response, $args)
    {
        $this->view->render($response, 'register.twig');
        return $response;
    }

    public function register(Request $request, Response $response, $args)
    {
        $formData = $request->getParsedBody();
        $customer = $this->createCustomerFromFormData($formData);
        try {
            $this->customerValidator->validateRegistry($customer);

            $this->entityManager->persist($customer);
            $this->entityManager->flush();

            $response->getBody()->write("Account " . $customer->getName() . " created.");
            $response = $response->withRedirect('/');
        } catch (AuthenticationException $e) {
            $errorField = $e->hasPasswordError()
                ? "password_error" : "username_error";

            $this->view->render($response, 'register.twig',
                [$errorField => $e->getMessage()]);
        }
        return $response;
    }

    private function createCustomerFromFormData($formData) {
        $customer = new Customer();

        $customer->setName($formData["username"]);
        if ($this->formDataIsFromRecoverPasswordPage($formData)) {
            $customer->setPassword($formData["old-password"]);
            $customer->setNewPassword($formData["new-password"]);
            $customer->setConfirmPassword($formData["confirm-new-password"]);
        } else {
            $customer->setPassword($formData["password"]);
        }

        if ($this->formDataIsFromRegisterPage($formData)) {
            $customer->setConfirmPassword($formData["confirm-password"]);
        }

        return $customer;
    }

    public function dispatchRecoverPasswordPage(Request $request, Response $response, $args)
    {
        return $this->view->render($response, 'recover-password.twig');
    }

    public function recoverPassword(Request $request, Response $response, $args)
    {
        $formData = $request->getParsedBody();
        $customer = $this->createCustomerFromFormData($formData);

        try {
            $this->customerValidator->validatePasswordRecovery($customer);

            return $response->withRedirect('/');
        } catch (AuthenticationException $e) {
            $errorField = ($e->hasDifferentPasswordError()) ?
                 'different_password_error' : 'login_error';

            $this->view->render($response, 'recover-password.twig',
                [$errorField => $e->getMessage()]);
        }
    }

    private function formDataIsFromRegisterPage($formData) : bool {
        return isset($formData["confirm-password"]);
    }

    private function formDataIsFromRecoverPasswordPage($formData) : bool {
        return isset($formData["old-password"]);
    }
}