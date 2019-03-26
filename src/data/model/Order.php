<?php
/**
 * Created by PhpStorm.
 * User: mcoppieters
 * Date: 26/03/19
 * Time: 09:13
 */

namespace Restaurant\data\model;


class Order
{
    private $id;
    private $customers;
    private $meals;

    /**
     * Order constructor.
     * @param $customers
     * @param $meals
     */
    public function __construct($customers, $meals)
    {
        $this->customers = $customers;
        $this->meals = $meals;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCustomers()
    {
        return $this->customers;
    }

    /**
     * @return mixed
     */
    public function getMeals()
    {
        return $this->meals;
    }
}