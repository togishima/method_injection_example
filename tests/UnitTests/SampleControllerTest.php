<?php

use App\Http\Controllers\SampleController;
use Nyholm\Psr7Server\ServerRequestCreatorInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class SampleControllerTest extends TestCase
{
    private StreamFactoryInterface $streamFactory;
    private ResponseFactoryInterface $responseFactory;
    private ServerRequestCreatorInterface $creator;

    public function setUp():void
    {
        $psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();
        $creator = new \Nyholm\Psr7Server\ServerRequestCreator(
                $psr17Factory, // ServerRequestFactory
                $psr17Factory, // UriFactory
                $psr17Factory, // UploadedFileFactory
                $psr17Factory  // StreamFactory
            );
        $this->creator = $creator;
        $this->responseFactory = $psr17Factory;
        $this->streamFactory = $psr17Factory;
    }

    /**
     * @test
     */
    public function testIndexAction()
    {
        // リクエストのモック
        $request = $this->creator->fromArrays(server: ['REQUEST_METHOD' => 'GET'], get: ['id' => '1']);
        // コントローラーのインスタンス化
        $controller = new SampleController($this->responseFactory, $this->streamFactory);
        // アクションの実行
        $response = $controller->index($request);

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