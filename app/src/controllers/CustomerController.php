<?php namespace App\Controller;

/**
 * Created by PhpStorm.
 * User: mcoppieters
 * Date: 02/04/19
 * Time: 10:50
 */

use App\Helper\CustomerValidator;
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

        $this->view->render($response, 'index.twig');
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
        $body = $request->getParsedBody();

        $customer = new Customer();
        $customer->setName($body["username"]);
        $customer->setPassword($body["password"]);
        $customer->setConfirmPassword($body["confirm-password"]);

        $authenticationAttempt = $this->customerValidator->validate($customer);

        if ($authenticationAttempt->getWasSuccesful()) {
            $this->entityManager->persist($customer);
            $this->entityManager->flush();

            $response->getBody()->write("Account " . $customer->getName() . " created.");
            $this->view->render($response, 'index.twig');
        } else {
            $errorField = $authenticationAttempt->hasPasswordError()
                ? "password_error" : "username_error";

            $this->view->render($response, 'register.twig',
                [$errorField => $authenticationAttempt->getErrorMessage()]);
        }
        return $response;
    }

    public function viewPost(Request $request, Response $response, $args)
    {
        $request->
        $this->logger->info("View post using Doctrine with Slim 3");

        $messages = $this->flash->getMessage('info');

        try {
            $post = $this->entityManager->find('App\Model\Post', intval($args['id']));
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
        }

        $this->view->render($response, 'post.twig', ['post' => $post, 'flash' => $messages]);
        return $response;
    }
}