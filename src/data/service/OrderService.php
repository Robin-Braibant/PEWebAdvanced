<?php namespace Restaurant\data\service;
/**
 * Created by PhpStorm.
 * User: mcoppieters
 * Date: 26/03/19
 * Time: 09:35
 */

use Restaurant\data\model\Order;

interface OrderService
{
    function add(Order $order);
    function getAll();
    function delete(Order $order);
    function getById(int $orderId);
}