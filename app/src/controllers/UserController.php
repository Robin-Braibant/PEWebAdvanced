<?php namespace App\Controller;

/**
 * Created by PhpStorm.
 * User: mcoppieters
 * Date: 02/04/19
 * Time: 10:50
 */

use App\Model\Customer;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UserController extends BaseController
{
    protected $container;

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

        $username = $body["username"];
        $password = $body["password"];
        $confirmPassword = $body["confirm-password"];

        if ($password === $confirmPassword) {
            $customer = new Customer();
            $customer->setName($username);
            $customer->setPassword($password);

            $this->entityManager->persist($customer);

            $response->getBody()->write("Account " . $username . " created.");
            $this->view->render($response, 'index.twig');
        } else {
            $this->view->render($response, 'register.twig');
/*            $response->getBody()->write("Password was not the same twice.");*/
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