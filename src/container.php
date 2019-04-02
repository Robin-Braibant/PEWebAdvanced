<?php namespace Restaurant\data;

use Restaurant\data\repository\CustomerRepository;
use Restaurant\data\repository\MealRepository;
use Restaurant\data\repository\OrderRepository;

$container = new \Slim\Container;

$container['customerService'] = function ($container) {
    $customerService = new CustomerRepository();
    return $customerService;
};

$container['orderService'] = function ($container) {
    $orderService = new OrderRepository();
    return $orderService;
};

$container['mealService'] = function ($container) {
    $mealService = new MealRepository();
    return $mealService;
};

$container['renderer'] = function ($container) {
    return new \Slim\Views\PhpRenderer('src/view');
};

var_export($container, true);
