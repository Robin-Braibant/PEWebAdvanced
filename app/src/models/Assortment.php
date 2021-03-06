<?php namespace App\Model;

use Doctrine\ORM\Mapping\OneToMany as OneToMany;
use Doctrine\ORM\Mapping\Entity as Entity;
use Doctrine\ORM\Mapping\Column as Column;
use Doctrine\ORM\Mapping\Table as Table;
use Doctrine\ORM\Mapping\GeneratedValue as GeneratedValue;
use Doctrine\ORM\Mapping\Id as Id;

/**
 * @Entity @Table(name="assortments")
 **/
class Assortment
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    protected $name;
    /** @Column(type="float") **/
    protected $price;

    /**
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param String $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param double $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return double
     */
    public function getPrice()
    {
        return $this->price;
    }

    public function __toString()
    {
        return "{ name: " . $this->getName() . " }";
    }


}
