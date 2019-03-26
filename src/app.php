<?php namespace Restaurant\data;

include("/var/www/html/vendor/autoload.php");

$container = include("container.php");

$app = new \Slim\App($container);
