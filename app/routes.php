<?php
// Routes

$app->get('/', 'App\Controller\CustomerController:dispatchLoginPage')
    ->setName('loginpage');

$app->post('/', 'App\Controller\CustomerController:login')
    ->setname('logincustomer');

$app->get('/register', 'App\Controller\CustomerController:dispatchRegisterPage')
    ->setname('registerpage');

$app->post('/register', 'App\Controller\CustomerController:register')
    ->setname('registeruser');

$app->get('/order', 'App\Controller\OrderController:dispatch')
    ->setname('orderpage');

