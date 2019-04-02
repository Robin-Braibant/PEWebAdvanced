<?php
// Routes

$app->get('/', 'App\Controller\UserController:dispatch')
    ->setName('homepage');

$app->get('/order', 'App\Controller\OrderController:dispatch')
    ->setName('orderpage');
