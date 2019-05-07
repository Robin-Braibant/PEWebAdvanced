<?php
/**
 * Created by PhpStorm.
 * User: mcoppieters
 * Date: 17/04/19
 * Time: 14:29
 */

namespace App\Model;

use Doctrine\ORM\Mapping\OneToOne as OneToOne;
use Doctrine\ORM\Mapping\JoinColumn as JoinColumn;
use Doctrine\ORM\Mapping\Entity as Entity;
use Doctrine\ORM\Mapping\Table as Table;
use Doctrine\ORM\Mapping\Column as Column;
use Doctrine\ORM\Mapping\Id as Id;
use Doctrine\ORM\Mapping\GeneratedValue as GeneratedValue;
use Doctrine\ORM\Mapping\ManyToOne as ManyToOne;

/**
 * @Entity @Table(name="meals")
 **/
class Meal
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    private $id;

    /**
     * @ManyToOne(targetEntity="Dish", cascade={"merge"})
     */
    private $dish;
    /**
     * @ManyToOne(targetEntity="Assortment", cascade={"merge"})
     */
    private $assortment;
    /**
     * @ManyToOne(targetEntity="Order", cascade={"persist"})
     */
    private $order;

    private $price;

    /**
     * @return mixed
     */
    public function getPrice()
    {
        $sum = 0;

        if ($this->dish) {
            $sum += $this->dish->getPrice();
        }
        if ($this->assortment) {
            $sum += $this->assortment->getPrice();
        }

        return $sum;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDish()
    {
        return $this->dish;
    }/**
     * @param mixed $dish
     */
    public function setDish($dish): void
    {
        $this->dish = $dish;
    }/**
     * @return mixed
     */
    public function getAssortment()
    {
        return $this->assortment;
    }/**
     * @param mixed $assortment
     */
    public function setAssortment($assortment): void
    {
        $this->assortment = $assortment;
    }

    public function __toString()
    {
        $name = $this->getDish()->getName();
        if ($this->getAssortment()) {
            $name = $name . " met " . $this->getAssortment()->getName();
        }
        return $name;
    }
}