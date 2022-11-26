<?php

use App\Foundation\DI\Container;
use App\Foundation\Http\Routing\Exceptions\RouteAlreadyExistsException;
use App\Foundation\Http\Routing\Route;
use App\Foundation\Http\Routing\Router;
use App\Http\Controllers\SampleController;
use Nyholm\Psr7Server\ServerRequestCreatorInterface;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private Router $router;

    public function setUp(): void
    {
        // ルートの定義
        $routes = [
            Route::get('/sample', SampleController::class, 'index'),
        ];
        $this->router = new Router($routes);
    }

    /**
     * @test
     */
    public function testDuplicateRouteNotRegisterable()
    {
        $this->expectException(RouteAlreadyExistsException::class);
        $router = new Router([
            Route::get('/sample', SampleController::class, 'index'),
            Route::get('/sample', SampleController::class, 'index')
        ]);
    }
}