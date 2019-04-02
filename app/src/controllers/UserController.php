<?php namespace App\Controller;

/**
 * Created by PhpStorm.
 * User: mcoppieters
 * Date: 02/04/19
 * Time: 10:50
 */

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UserController extends BaseController
{
    public function dispatch(Request $request, Response $response, $args)
    {
        $this->logger->info("Home page action dispatched");

        $this->flash->addMessage('info', 'Sample flash message');

        $this->view->render($response, 'index.twig');
        return $response;
    }
}