<?php

namespace App\Foundation\Http\Routing;

use App\Foundation\DI\Container;
use App\Foundation\Http\Enums\HttpMethod;
use Psr\Http\Message\ResponseInterface;

class Route
{
    private function __construct(
        public readonly HttpMethod $httpMethod,
        public readonly string $uri,
        public readonly string $controller,
        public readonly string $action,
    ) {
    }

    public static function get(string $uri, string $controller, ?string $action = null): self
    {
        $action = $action ?? '__invoke';
        return new self(HttpMethod::GET, $uri, $controller, $action);
    }

    /**
     * 以下略...
     */

    public function run(): ResponseInterface
    {
        // コントローラーのインスタンス化
        $controller = Container::instance()->get($this->controller);
        // 依存クラスの取得
        $dependencies = Container::instantiateDependencies($this->controller, $this->action);
        // アクションの実行
        return $controller->{$this->action}(...$dependencies);
    }
}
