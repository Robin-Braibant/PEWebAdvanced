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
        if (!isset($_SESSION)) {
            session_start();
        }

        $tokens = $this->csrfTokenManager->generateTokens($request);

        return $this->view->render($response, 'index.twig', $tokens);
    }

    public function login(Request $request, Response $response, $args)
    {
        if ($request->getAttribute('csrf_status')) {
            $this->logger->info('Possible CSRF attempt detected');
            return $response->withRedirect('/');
        }
        $this->logger->info('valid request');

        $formData = $request->getParsedBody();
        $customer = $this->createCustomerFromFormData($formData);

        try {
            $this->customerValidator->validateLogin($customer);

            return $response->withStatus(302)->withHeader('Location', '/order');
        } catch (AuthenticationException $e) {
            return $this->view->render($response, 'index.twig', ['login_error' => $e->getMessage()]);
        }
    }

    public function dispatchRegisterPage(Request $request, Response $response, $args)
    {
        $tokens = $this->csrfTokenManager->generateTokens($request);

        return $this->view->render($response, 'register.twig', $tokens);
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
        $tokens = $this->csrfTokenManager->generateTokens($request);

        return $this->view->render($response, 'recover-password.twig', $tokens);
    }

    public function recoverPassword(Request $request, Response $response, $args)
    {
        $formData = $request->getParsedBody();
        $customerData = $this->createCustomerFromFormData($formData);

        try {
            $this->customerValidator->validatePasswordRecovery($customerData);

            $customer = $this->entityManager
                ->getRepository('App\Model\Customer')
                ->findBy([ 'name' => $customerData->getName() ])[0];

            $customer->setPassword($customerData->getNewPassword());

            $this->entityManager->merge($customer); // update
            $this->entityManager->flush();

            $this->logger->info('new password: ' . $customer->getPassword());

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