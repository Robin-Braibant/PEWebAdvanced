<?php
/**
 * Created by PhpStorm.
 * User: mcoppieters
 * Date: 26/03/19
 * Time: 09:12
 */

namespace Restaurant\data\model;


class Meal
{
    private $id;
    private $name;
    private $image;
    private $price;

    /**
     * Meal constructor.
     * @param Integer $id
     * @param String $name
     * @param String $image
     * @param double $price
     */
    public function __construct($name, $image, $price)
    {
        $this->name = $name;
        $this->image = $image;
        $this->price = $price;
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return String
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }
}