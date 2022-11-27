<?php

namespace App\Foundation\Http\Routing;

use App\Foundation\DI\Container;
use App\Foundation\Http\Enums\HttpMethod;
use App\Foundation\Http\Routing\Exceptions\MethodNotAllowedException;
use App\Foundation\Http\Routing\Exceptions\RouteAlreadyExistsException;
use App\Foundation\Http\Routing\Exceptions\RouteNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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

    /**
     * Resolve Request
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws MethodNotAllowedException|RouteNotFoundException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (!array_key_exists($request->getMethod(), $this->routes)) {
            throw new MethodNotAllowedException();
        }
        $route = $this->findRoute($request);
        return $route->run();
    }

    /**
     * @param ServerRequestInterface $request
     * @return Route
     * @throws RouteNotFoundException
     */
    private function findRoute(ServerRequestInterface $request): Route
    {
        $matchedRoutes = array_filter(
            $this->routes[$request->getMethod()],
            fn (Route $route) => $route->uri === $request->getUri()->getPath()
        );
        if (count($matchedRoutes) !== 1) {
            throw new RouteNotFoundException();
        }
        return current($matchedRoutes);
    }
}