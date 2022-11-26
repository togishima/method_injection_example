<?php

use App\Foundation\DI\Container;
use App\Foundation\Http\Routing\Exceptions\RouteNotFoundException;
use App\Foundation\Http\Routing\Router;
use Nyholm\Psr7Server\ServerRequestCreatorInterface;

require_once __DIR__.'/../vendor/autoload.php';

$serverRequestCreator = Container::instance()->get(ServerRequestCreatorInterface::class);
$request = $serverRequestCreator->fromGlobals();

$routes = include __DIR__.'/../routes/routes.php';
$router = new Router($routes);

try {
    $response = $router->resolve($request);
} catch (RouteNotFoundException $e) {
    header('HTTP/1.1 404 Not Found');
    exit;
}
echo $response->getBody()->__toString();