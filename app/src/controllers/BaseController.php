<?php

namespace App\Controller;

use Slim\Container;
class BaseController
{
    protected $view;
    protected $logger;
    protected $flash;
    protected $csrf;
    /**
     * @var EntityManager
     */
    protected $entityManager;  // Entities Manager

    public function __construct(Container $container)
    {
        $this->view = $container->get('view');
        $this->logger = $container->get('logger');
        $this->flash = $container->get('flash');
        $this->entityManager = $container->get('em');
        $this->csrf = $container->get('csrf');
    }
}