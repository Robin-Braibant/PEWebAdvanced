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
    private static $PAGE_SIZE = 5;

    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function dispatch(Request $request, Response $response, $args)
    {
        $nameKey = $this->csrf->getTokenNameKey();
        $valueKey = $this->csrf->getTokenValueKey();
        $name = $request->getAttribute($nameKey);
        $value = $request->getAttribute($valueKey);

        $this->logger->info("name: " . $name);
        $this->logger->info("value: " .$value);
        $this->logger->info("nameKey: " . $nameKey);
        $this->logger->info("valueKey: " .$valueKey);

        $tokenName = $this->csrf->getTokenNameKey();
        $tokenValue = $request->getAttribute($tokenName);
        if (!$tokenValue) {
            if (isset($_SESSION['csrf-token'])) {
                $sessionTokenValue = $_SESSION['csrf-token'];

                if ($sessionTokenValue !== $tokenValue) {
                    $this->logger->info("CSRF attempt detected");
                    return $response->withRedirect('/order');
                }
            } else {
                $tokenValue = $this->csrf->getTokenService()->generate();
                $_SESSION['csrf-token'] = $tokenValue;
            }
        }


        if (isset($_SESSION['order'])) {
            $order = $_SESSION['order'];
            if ($this->dishWasAdded($request)) {
                $this->addOrderMeal($order, $request);
            }
        } else {
            $order = new Order();
            $this->entityManager->persist($order);
            $this->entityManager->flush($order);
            $_SESSION['order'] = $order;
        }

        $pageNumber = $request->getQueryParam('page') ?: 1;
        $mealsOnPage = $order->getMealsOnPage($pageNumber, self::$PAGE_SIZE);
        $pageCount = ceil($order->mealCount() / self::$PAGE_SIZE);

        return $this->view->render($response, 'order.twig', [
            'dishes' => $this->entityManager->getRepository('\App\Model\Dish')->findAll(),
            'assortments' => $this->entityManager->getRepository('\App\Model\Assortment')->findAll(),
            'meals' => $mealsOnPage,
            'pages' => $pageCount,
            'currentPage' => $pageNumber,
            'tokenName' => $tokenName,
            'tokenValue' => $tokenValue
        ]);
    }

    public function confirmOrder(Request $request, Response $response, $args) {
        session_destroy();
        return $response->withRedirect('/');
    }

    public function deleteFromOrder(Request $request, Response $response, $args) {
        $formData = $request->getParsedBody();
        $mealId = (int)$formData['meal-id'];
        $this->logger->info('deleting meal with id ' . $mealId);

        $order = $_SESSION['order'];
        $order->deleteMeal($mealId);

        return $response->withRedirect('/order');
    }

    private function addOrderMeal($order, $request) {
        $meal = new Meal();
        $this->entityManager->persist($meal);
        $this->entityManager->flush($meal);

        $dishId = $request->getQueryParam('dish');
        $dish = $this->entityManager->find('App\Model\Dish', $dishId);
        $this->logger->info('dish id:' . $dish->getId());
        $meal->setDish($dish);

        if ($this->queryParameterIsPresent($request, 'assortment')) {
            $assortmentId = $request->getQueryParam('assortment');
            $assortment = $this->entityManager->find('App\Model\Assortment', $assortmentId);
            $meal->setAssortment($assortment);
        }

        $this->logger->info($meal);
        $order->addMeal($meal);
    }

    private function dishWasAdded($request) {
        return $request->getQueryParam('dish');
    }

    private function queryParameterIsPresent($request, $parameter) {
        return !!$request->getQueryParam($parameter);
    }
}