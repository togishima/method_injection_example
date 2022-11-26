<?php

namespace App\Http\Controllers;

use App\Foundation\Http\Controllers\BaseController;
use App\Models\SampleModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SampleController extends BaseController
{
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        // リクエストのGETパラメーターからIDを抽出
        $id = (int)$request->getQueryParams()['id'];
        // IDを元にアクティブレコードを使って対象のデータを取得
        $model = SampleModel::find($id);
        // レスポンス（JSON）を返す
        return $this->response([
            'message' => 'this is index controller',
            'model' => $model->name,
            'child' => $model->child->name,
        ]);
    }

    public function update(ServerRequestInterface $request): ResponseInterface
    {
        return $this->response('update() called');
    }
}