<?php namespace App\Controller;

/**
 * Created by PhpStorm.
 * User: mcoppieters
 * Date: 02/04/19
 * Time: 10:50
 */

use App\Helper\CustomerValidator;
use App\Model\AuthenticationException;
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
        $this->logger->info("Home page was loaded");

        $this->flash->addMessage('info', 'Sample flash message');

        $this->view->render($response, 'index.twig');
        return $response;
    }

    public function login(Request $request, Response $response, $args)
    {
        $this->logger->info("Home page action dispatched");

        $formData = $request->getParsedBody();
        $customer = $this->createCustomerFromFormData($formData);

        try {
            $this->customerValidator->validateLogin($customer);

            $this->view->render($response, 'order.twig');
        } catch (AuthenticationException $e) {
            $this->view->render($response, 'index.twig',
                ['user_error' => $e->getMessage()]);
        }

        return $response;
    }

    public function dispatchRegisterPage(Request $request, Response $response, $args)
    {
        $this->logger->info("Home page action dispatched");

        $this->view->render($response, 'register.twig');
        return $response;
    }

    public function register(Request $request, Response $response, $args)
    {
        $this->logger->info("Home page action dispatched");

        $formData = $request->getParsedBody();
        $customer = $this->createCustomerFromFormData($formData);
        try {
            $this->customerValidator->validateRegistry($customer);

            $this->entityManager->persist($customer);
            $this->entityManager->flush();

            $response->getBody()->write("Account " . $customer->getName() . " created.");
            $this->view->render($response, 'index.twig');
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
        $customer->setPassword($formData["password"]);
        if ($this->formDataIsFromRegisterPage($formData)) {
            $customer->setConfirmPassword($formData["confirm-password"]);
        }

        return $customer;
    }

    private function formDataIsFromRegisterPage($formData) : bool {
        return isset($formData["confirm-password"]);
    }
}