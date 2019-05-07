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

$app->get('/recover-password', 'App\Controller\CustomerController:dispatchRecoverPasswordPage')
    ->setname('recover-password');

$app->post('/recover-password', 'App\Controller\CustomerController:recoverPassword')
    ->setname('recover-password');

$app->get('/order', 'App\Controller\OrderController:dispatch')
    ->setname('orderpage');

$app->post('/order/confirm', 'App\Controller\OrderController:confirmOrder')
    ->setname('addToOrder');

$app->post('/order/delete', 'App\Controller\OrderController:deleteFromOrder')
    ->setName('deleteFromOrder');