<?php namespace Restaurant\data\repository;
/**
 * Created by PhpStorm.
 * User: mcoppieters
 * Date: 26/03/19
 * Time: 09:44
 */


use Restaurant\data\model\Meal;
use Restaurant\data\service\MealService;

class MealRepository implements MealService
{
    private $connectionFactory;

    /**
     * MealRepository constructor.
     * @param $connectionFactory
     */
    public function __construct($connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
    }

    function add(Meal $meal)
    {
        $connection = $this->connectionFactory->getConnection();

        $statement = $connection->prepare("INSERT INTO meal (id, name, image, price) VALUES (?, ?, ?, ?)");
        $statement->execute($meal->getId(), $meal->getName(), $meal->getImage(), $meal->getPrice());

        $statement = null;
        $connection = null;
    }

    function getAll()
    {
        // connection aanmaken
        $connection = $this->connectionFactory->getConnection();

        // array met meals klaarzetten
        $meals = array();
        // query uitvoeren
        $statement = $connection->query("SELECT * FROM meal");
        foreach ($statement as $row)
        {
            // read data, make meal object and add to array
            $name = $row['name'];
            $image = $row['image'];
            $price = $row['price'];
            $meals.$this->add(new meal($name, $image, $price));
        }

        // resultaat teruggeven
        return $meals;

        // close connection
        $statement = null;
        $connection = null;
    }

    function delete(Meal $meal)
    {
        $connection = $this->connectionFactory->getConnection();

        $statement = $connection->prepare("DELETE FROM meal WHERE id = ?");
        $statement->execute($meal->getId());

        $statement = null;
        $connection = null;
    }

    function getById(int $mealId)
    {
        // connection aanmaken
        $connection = $this->connectionFactory->getConnection();

        // query uitvoeren
        $statement = $connection->prepare("SELECT * FROM meal WHERE ID = ?");
        $statement->execute([$mealId]);
        $meal = $statement->fetch();

        // resultaat teruggeven
        return $meal;

        // close connection
        $statement = null;
        $connection = null;
    }
}