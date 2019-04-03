<?php namespace App\Model;

use Doctrine\ORM\Mapping\Entity as Entity;
use Doctrine\ORM\Mapping\Column as Column;
use Doctrine\ORM\Mapping\Table as Table;
use Doctrine\ORM\Mapping\GeneratedValue as GeneratedValue;
use Doctrine\ORM\Mapping\Id as Id;

/**
 * @Entity @Table(name="orders")
 **/
class Order
{
    /** @Id @Column(type="integer") @GeneratedValue **/
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