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
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function dispatch(Request $request, Response $response, $args)
    {
        $dishes = $this->entityManager->getRepository('App\Model\Dish')->findAll();
        $assortments = $this->entityManager->getRepository('App\Model\Assortment')->findAll();

        $formData = $request->getParsedBody();
        $orderId = $formData['order-id'];
        if ($orderId) {
            $order = $this->entityManager->getRepository('App\Model\Order')->find($orderId);
        } else {
            $order = new Order();
        }
        $this->entityManager->persist($order);
        $this->entityManager->flush();


        return $this->view->render($response, 'order.twig', [
            'dishes' => $dishes,
            'assortments' => $assortments,
            'order' => $order,
        ]);
    }

    public function addToOrder(Request $request, Response $response, $args) {
        $formData = $request->getParsedBody();
        $orderId = $formData['order-id'];
        $order = $this->entityManager->getRepository('App\Model\Order')->find($orderId);

        $this->setOrderMealFromFormData($formData);

        $dishes = $this->entityManager->getRepository('App\Model\Dish')->findAll();
        $assortments = $this->entityManager->getRepository('App\Model\Assortment')->findAll();

        return $this->view->render($response, 'order.twig', [
            'dishes' => $dishes,
            'assortments' => $assortments,
            'order' => $order,
        ]);
    }

    public function deleteFromOrder(Request $request, Response $response, $args) {
        $this->logger->info("Order page dispatched");

        $id = $args['id'];

        $this->order->deleteMeal($id);

        return $response->withRedirect('/order');
    }

    private function setOrderMealFromFormData($formData) {
        $meal = new Meal();
        $order = $this->entityManager->getRepository('App\Model\order')->find( $formData['order-id']);

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

        $order->addMeal($meal);
    }

    private function formDataPropertyWasPassed($formData, $property) {
        return isset($formData[$property]);
    }
}