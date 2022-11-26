<?php

use App\Foundation\DI\Container;
use App\Foundation\Http\Routing\Exceptions\MethodNotAllowedException;
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
        $this->creator = Container::instance()->get(ServerRequestCreatorInterface::class);
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

    /**
     * @test
     */
    public function resolve()
    {
        // リクエストのモック
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/sample';
        $_GET['id'] = '1';
        $request = $this->creator->fromGlobals();
        // リクエストの処理をルーターに移譲
        $response = $this->router->resolve($request);
        // 処理された後のレスポンス確認
        $this->assertEquals(
            json_encode([
                'message' => 'this is index controller',
                'model' => 'SampleModel',
                'child' => 'ChildModel',
            ]),
            $response->getBody()->__toString()
        );
    }

    /**
     * @test
     */
    public function methodNotAllowed()
    {
        $this->expectException(MethodNotAllowedException::class);
        // リクエストのモック
        $request = $this->creator->fromArrays(
            server: ['REQUEST_METHOD' => 'QUERY', 'REQUEST_URI' => '/sample'],
            get: ['id' => '1']
        );
        // リクエストの処理をルーターに移譲
        $response = $this->router->resolve($request);
    }
}