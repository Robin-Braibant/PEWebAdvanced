<?php namespace App\Model;
/**
 * Created by PhpStorm.
 * User: mcoppieters
 * Date: 26/03/19
 * Time: 09:12
 */

/**
 * @Entity @Table(name="meals")
 **/
class Meal
{
    /** @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    protected $name;
    /** @Column(type="string") **/
    protected $image;
    /** @Column(type="double") **/
    protected $price;


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
     * @return double
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param String $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param String $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * @param double $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }


}