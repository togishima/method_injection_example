<?php

namespace App\Foundation\Http\Routing\Contracts;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface RouterInterface
{
    /**
     * 引数でRouteInterfaceを実装したリストを受け取り保持する
     * 
     * @param array<RouteInterface>
     */
    public function __construct($routes = []);

    /**
     * リクエストに対応したルーティングの処理結果を返す
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws MethodNotAllowedException|RouteNotFoundException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface;
}