<?php namespace Restaurant\data\service;
/**
 * Created by PhpStorm.
 * User: mcoppieters
 * Date: 26/03/19
 * Time: 09:34
 */

use Restaurant\data\model\Meal;

interface MealService
{
    function add(Meal $meal);
    function getAll();
    function delete(Meal $meal);
    function getById(int $mealId);
}