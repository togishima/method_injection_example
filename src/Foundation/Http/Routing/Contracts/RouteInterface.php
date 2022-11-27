<?php

namespace App\Foundation\Http\Routing\Contracts;

use Psr\Http\Message\ResponseInterface;

interface Route
{
    /**
     * 引数でルーティング情報を受け取ってルート情報をクラスとしてインスタンス化する
     * （アクション名は省略可）
     *
     * @param string $uri
     * @param class-string $controller
     * @param string $action
     * @return self
     */
    public static function get(string $uri, string $controller, string $action = '__invoke'): self;

    /**
     * ルーティング情報として登録されたコントローラーを実行した返り値（Responseオブジェクト）を返す
     *
     * @return ResponseInterface
     */
    public function run(): ResponseInterface;
}