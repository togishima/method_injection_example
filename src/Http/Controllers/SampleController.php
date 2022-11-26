<?php

namespace App\Http\Controllers;

use App\Models\SampleModel;

class SampleController
{
    public function index(SampleModel $model)
    {
        $response = [
            'message' => 'this is index controller',
            'model' => $model->name,
            'child' => $model->child->name,
        ];

        return $response;
    }
}