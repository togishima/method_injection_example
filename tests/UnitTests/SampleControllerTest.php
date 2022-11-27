<?php

use App\Foundation\DI\Container;
use App\Http\Controllers\SampleController;
use App\Http\Requests\SampleRequest;
use Nyholm\Psr7Server\ServerRequestCreatorInterface;
use PHPUnit\Framework\TestCase;

class SampleControllerTest extends TestCase
{
    private ServerRequestCreatorInterface $creator;

    public function setUp():void
    {
        $this->creator = Container::instance()->get(ServerRequestCreatorInterface::class);
        $this->controller = Container::instance()->get(SampleController::class);
    }

    /**
     * @test
     */
    public function testIndexAction()
    {
        // リクエストのモック
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_GET['id'] = '1';
        $request = new SampleRequest($this->creator->fromGlobals());
        // アクションの実行
        $response = $this->controller->index($request);
        // レスポンスの確認
        $this->assertEquals(
            json_encode([
                'message' => 'this is index controller',
                'model' => 'SampleModel',
                'child' => 'ChildModel',
            ]),
            $response->getBody()->__toString()
        );
    }
}