<?php namespace App\Controller;
/**
 * Created by PhpStorm.
 * User: mcoppieters
 * Date: 02/04/19
 * Time: 10:50
 */

use App\Model\Meal;
use App\Model\Order;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Container;

class OrderController extends BaseController
{
    private $order;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->order = new Order();
    }

    public function dispatch(Request $request, Response $response, $args)
    {
        $this->logger->info("Order page dispatched");

        $dishes = $this->entityManager->getRepository('App\Model\Dish')->findAll();
        $assortments = $this->entityManager->getRepository('App\Model\Assortment')->findAll();

        return $this->view->render($response, 'order.twig', [
            'dishes' => $dishes,
            'assortments' => $assortments
        ]);
    }

    public function addToOrder(Request $request, Response $response, $args) {
        $this->logger->info("Order page dispatched");

        $formData = $request->getParsedBody();

        $this->setOrderMealFromFormData($formData);

        $dishes = $this->entityManager->getRepository('App\Model\Dish')->findAll();
        $assortments = $this->entityManager->getRepository('App\Model\Assortment')->findAll();

        return $this->view->render($response, 'order.twig', [
            'dishes' => $dishes,
            'assortments' => $assortments,
            'order' => $this->order,
        ]);
    }

    private function setOrderMealFromFormData($formData) {
        $meal = new Meal();

        if ($this->formDataPropertyWasPassed($formData, 'dish')) {
            $dishId = $formData['dish'];
            $dish = $this->entityManager->getRepository('App\Model\Dish')->find($dishId);
            $meal->setDish($dish);
        }

        if ($this->formDataPropertyWasPassed($formData, 'assortment')) {
            $assortmentId = $formData['assortment'];
            $assortment = $this->entityManager->getRepository('App\Model\Assortment')->find($assortmentId);
            $meal->setAssortment($assortment);
        }

        $this->order->addMeal($meal);
    }

    private function formDataPropertyWasPassed($formData, $property) {
        return isset($formData[$property]);
    }
}