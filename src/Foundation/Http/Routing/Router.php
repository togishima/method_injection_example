<?php

namespace App\Foundation\Http\Routing;

use App\Foundation\DI\Container;
use App\Foundation\Http\Enums\HttpMethod;
use App\Foundation\Http\Routing\Exceptions\MethodNotAllowedException;
use App\Foundation\Http\Routing\Exceptions\RouteAlreadyExistsException;
use App\Http\Controllers\SampleController;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;


class Router
{
    /** @var array<string,array<Route> */
    private array $routes;

    /**
     * @param array<Route>>
     */
    public function __construct($routes = [])
    {
        // 格納時にHTTPメソッドによってグルーピング
        foreach(HttpMethod::cases() as $httpdMethod) {
            $this->routes[$httpdMethod->name] = [];
        }
        foreach($routes as $route) {
            if (!$route instanceof Route) {
                continue;
            }
            // 重複ルートチェック
            if ($this->isDuplicate($route)) {
                throw new RouteAlreadyExistsException();
            }
            $this->routes[$route->httpMethod->name][] = $route;
        }
    }

    private function isDuplicate(Route $route): bool
    {
        $duplicate = array_filter(
            $this->routes[$route->httpMethod->name],
            fn (Route $registeredRoute) => $registeredRoute->uri === $route->uri
        );
        return count($duplicate) !== 0;
    }
}