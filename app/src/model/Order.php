<?php namespace App\Model;
/**
 * Created by PhpStorm.
 * User: mcoppieters
 * Date: 26/03/19
 * Time: 09:13
 */

/**
 * @Entity @Table(name="orders")
 **/
class Order
{
    /** @Column(type="integer") @GeneratedValue **/
    private $id;
    /** @Column(type="array") **/
    private $customers;
    /** @Column(type="array") **/
    private $meals;


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

    /**
     * @param mixed $customers
     */
    public function setCustomers($customers): void
    {
        $this->customers = $customers;
    }

    /**
     * @param mixed $meals
     */
    public function setMeals($meals): void
    {
        $this->meals = $meals;
    }


}