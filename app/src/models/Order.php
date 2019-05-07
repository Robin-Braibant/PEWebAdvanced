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

    private $price;
    private $taxes;
    private $totalPrice;

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
     * @param int $page
     * @param int $pageSize
     * @return mixed
     */
    public function getMealsOnPage(int $page, int $pageSize)
    {
        $startIndex = ($page - 1) * 5;
        return array_slice($this->meals->toArray(), $startIndex, $pageSize);
    }

    public function mealCount() {
        return $this->meals->count();
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

    public function deleteMeal(int $id): void
    {
        for ($i = 0; $i < $this->meals->count(); $i++) {
            if ($this->meals[$i]->getId() == $id) {
                unset($this->meals[$i]);
                break;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        $totalPrice = 0;
        for ($i = 0; $i < $this->meals->count(); $i++) {
            $meal = $this->meals[$i];
            if ($meal) {
                $totalPrice += $this->meals[$i]->getPrice();
            }
        }
        return $totalPrice;
    }

    public function getTaxes() {
        return $this->getPrice() * 0.06;
    }

    public function getTotalPrice() {
        return $this->getPrice() + $this->getTaxes();
    }

    public function __toString()
    {
        return "{ meals: [" . implode($this->getMeals()->toArray()) . " ], customer: " . $this->getCustomer() . " }";
    }

}