<?php

declare(strict_types=1);
// Display errors in development mode
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use DI\ContainerBuilder;
use FastRoute\RouteCollector;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Middlewares\Utils\Dispatcher;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;

use Alumni\Presentation\Middleware\AuthMiddleware;
use Alumni\Presentation\Middleware\TwigContextMiddleware;

require __DIR__ . '/../vendor/autoload.php';

// Load environment variables
/** @var \Dotenv\Dotenv $dotenv */
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Container configuration
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/../bin/dependency.php');
$containerBuilder->useAutowiring(true);
$container = $containerBuilder->build();

// Create route dispatcher
$routes = \FastRoute\simpleDispatcher(function (RouteCollector $r) {
    $routesArray = require __DIR__ . '/../bin/route.php';
    foreach ($routesArray as $routeDef) {
        $r->addRoute($routeDef['method'], $routeDef['path'], $routeDef['handler']);
    }
});

$dispatcher = new Dispatcher([
    new FastRoute($routes),
    $container->get(AuthMiddleware::class),
    $container->get(TwigContextMiddleware::class),
    new RequestHandler($container)
]);

// Create request
$request = ServerRequestFactory::fromGlobals();

try {
    $response = $dispatcher->dispatch($request);
    
} catch (\Throwable $e) {
    $response = new Response();
    $response = $response->withStatus(500);
    $response->getBody()->write('Internal Server Error: ' . $e->getMessage() . ' on line: ' . $e->getLine() . ' in file: ' . $e->getFile());
}

// Emit response
(new SapiEmitter())->emit($response);
