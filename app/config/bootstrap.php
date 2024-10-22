<?php

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use nrv\middlewares\CorsMiddleware;



$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/constantes.php');
$builder->addDefinitions(__DIR__ . '/settings.php' );
$builder->addDefinitions(__DIR__ . '/dependencies.php');
$builder->addDefinitions(__DIR__ . '/actions.php');

$c=$builder->build();
$app = AppFactory::createFromContainer($c);


$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware($c->get('displayErrorDetails'), false, false);
$app->addMiddleware($c->get(CorsMiddleware::class));

$app = (require_once __DIR__ . '/routes.php')($app);


return $app;
