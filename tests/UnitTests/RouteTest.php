<?php

namespace App\Foundation\Http\Routing;

use App\Foundation\Http\Enums\HttpMethod;
use App\Http\Controllers\SampleController;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    /**
     * @test
     */
    public function getMethod()
    {
        $route = Route::get('/', SampleController::class, 'index');

        $this->assertSame($route->httpMethod, HttpMethod::GET);
        $this->assertSame($route->uri, '/');
        $this->assertSame($route->controller, SampleController::class);
        $this->assertSame($route->action, 'index');
    }

    /**
     * @test
     */
    public function actionIsNullable()
    {
        $route = Route::get('/', SampleController::class);
        $this->assertSame($route->action, '__invoke');
    }

    /**
     * 時間の都合でGetのみ実装
     */
}