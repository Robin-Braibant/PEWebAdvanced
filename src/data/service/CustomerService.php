<?php namespace Restaurant\data\service;
/**
 * Created by PhpStorm.
 * User: mcoppieters
 * Date: 26/03/19
 * Time: 09:32
 */

use Restaurant\data\model\Customer;

interface CustomerService
{
    function add(Customer $customer);
    function getAll();
    function delete(Customer $customer);
    function getById(int $customerId);
}