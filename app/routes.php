<?php
// Routes

$app->get('/', 'App\Controller\UserController:dispatchLoginPage')
    ->setName('loginpage');

$app->post('/', 'App\Controller\UserController:login')
    ->setname('loginuser');

$app->get('/register', 'App\Controller\UserController:dispatchRegisterPage')
    ->setname('registerpage');

$app->post('/register', 'App\Controller\UserController:register')
    ->setname('registeruser');

$app->get('/order', 'App\Controller\OrderController:dispatch')
    ->setname('orderpage');

