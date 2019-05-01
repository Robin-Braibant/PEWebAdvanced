<?php namespace App\Model;

use Doctrine\ORM\Mapping\Entity as Entity;
use Doctrine\ORM\Mapping\Table as Table;
use Doctrine\ORM\Mapping\Column as Column;
use Doctrine\ORM\Mapping\GeneratedValue as GeneratedValue;
use Doctrine\ORM\Mapping\Id as Id;
use Doctrine\ORM\Mapping\OneToMany as OneToMany;
use Doctrine\ORM\Mapping\JoinColumn as JoinColumn;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table(name="orders")
 **/
class Order
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    private $id;

    private $customer;

    /**
     * @OneToMany(targetEntity="Meal", mappedBy="order", cascade={"persist"})
     */
    private $meals;

    /**
     * Order constructor.
     */
    public function __construct()
    {
        $this->meals = new ArrayCollection();
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
    public function getCustomer()
    {
        return $this->customer;
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
    public function setCustomer($customer): void
    {
        $this->customer = $customer;
    }

    public function addMeal(Meal $meal): void
    {
        $this->meals->add($meal);
    }

    public function deleteMeal($id): void
    {
        unset($this->meals[$id]);
    }

    public function __toString()
    {

        return "{ meals: [" . implode($this->getMeals()->toArray()) . " ], customer: " . $this->getCustomer() . " }";
    }
}