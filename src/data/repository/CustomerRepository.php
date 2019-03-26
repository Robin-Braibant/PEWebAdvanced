<?php namespace Restaurant\data\repository;
/**
 * Created by PhpStorm.
 * User: mcoppieters
 * Date: 26/03/19
 * Time: 09:44
 */

use Restaurant\data\model\Customer;
use Restaurant\data\service\CustomerService;

class CustomerRepository implements CustomerService
{

    function add(Customer $customer)
    {
        // TODO: Implement add() method.
    }

    function getAll()
    {
        // TODO: Implement getAll() method.
    }

    function delete(Customer $customer)
    {
        // TODO: Implement delete() method.
    }

    function getById(int $customerId)
    {
        // TODO: Implement getById() method.
    }
}