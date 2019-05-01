<?php namespace App\Controller;
/**
 * Created by PhpStorm.
 * User: mcoppieters
 * Date: 02/04/19
 * Time: 10:50
 */

use App\Model\Assortment;
use App\Model\Customer;
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
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['order'])) {
            $order = $_SESSION['order'];
            if ($this->dishWasAdded($request)) {
                $this->addOrderMeal($order, $request);
                $this->entityManager->persist($order);
                $this->entityManager->flush($order);
            }
        } else {
            $order = new Order();
            $this->entityManager->persist($order);
            $this->entityManager->flush($order);
            $_SESSION['order'] = $order;
        }

        $assortmentsBuilder = $this->entityManager->getRepository('App\Model\Assortment')->createQueryBuilder('p');
        $dishBuilder = $this->entityManager->getRepository('App\Model\Dish')->createQueryBuilder('p');

        return $this->view->render($response, 'order.twig', [
            'dishes' => $this->getDistinct($dishBuilder),
            'assortments' => $this->getDistinct($assortmentsBuilder),
            'order' => $order,
        ]);
    }

    public function confirmOrder(Request $request, Response $response, $args) {
        session_destroy();
        return $response->withRedirect('/order');
    }

    private function getDistinct($queryBuilder) {
        return $queryBuilder
                    ->SELECT('p.id,p.name')
                    ->getQuery()
                    ->getResult();
    }

    public function deleteFromOrder(Request $request, Response $response, $args) {
        $id = $args['id'];

        $order = $_SESSION['order'];
        $this->logger->info("Deleting meal with id " . $id);
        $order->deleteMeal($id);
        $this->entityManager->persist($order);
        $this->entityManager->flush($order);


        return $response->withRedirect('/order');
    }

    private function addOrderMeal($order, $request) {
        $meal = new Meal();

        $dishId = $request->getQueryParam('dish');
        $dish = $this->entityManager->find('App\Model\Dish', $dishId);
        $meal->setDish($dish);

        if ($this->queryParameterIsPresent($request, 'assortment')) {
            $assortmentId = $request->getQueryParam('assortment');
            $assortment = $this->entityManager->find('App\Model\Assortment', $assortmentId);
            $meal->setAssortment($assortment);
        }

        $order->addMeal($meal);
    }

    private function dishWasAdded($request) {
        return $request->getQueryParam('dish');
    }

    private function queryParameterIsPresent($request, $parameter) {
        return !!$request->getQueryParam($parameter);
    }
}