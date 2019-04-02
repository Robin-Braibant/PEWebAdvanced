<?php namespace Restaurant\data;

include("/var/www/html/vendor/autoload.php");
include("./src/container.php");

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App();

$app->get('/', function(Request $request, Response $response) {
    $response = $response->withHeader('Content-Type', 'text/html');

    $response->getBody()->write('Hello world');

    $customerService = $this->get('customerService');

    $customerService->getAll();

    return $response;
});

$app->run();