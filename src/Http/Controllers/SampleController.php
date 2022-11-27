<?php

namespace App\Http\Controllers;

use App\Foundation\Http\Controllers\BaseController;
use App\Http\Requests\SampleRequest;
use App\Models\SampleModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SampleController extends BaseController
{
    public function index(SampleRequest $request): ResponseInterface
    {
        // IDを元にアクティブレコードを使って対象のデータを取得
        $model = SampleModel::find($request->id);
        // レスポンス（JSON）を返す
        return $this->response([
            'message' => 'this is index controller',
            'model' => $model->name,
            'child' => $model->child->name,
        ]);
    }
}