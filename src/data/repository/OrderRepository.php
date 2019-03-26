<?php namespace Restaurant\data\repository;
/**
 * Created by PhpStorm.
 * User: mcoppieters
 * Date: 26/03/19
 * Time: 09:44
 */

use Restaurant\data\model\Order;
use Restaurant\data\service\OrderService;

class OrderRepository implements OrderService
{

    function add(Order $order)
    {
        // TODO: Implement add() method.
    }

    function getAll()
    {
        // TODO: Implement getAll() method.
    }

    function delete(Order $order)
    {
        // TODO: Implement delete() method.
    }

    function getById(int $orderId)
    {
        // TODO: Implement getById() method.
    }
}