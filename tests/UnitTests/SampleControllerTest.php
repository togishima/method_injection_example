<?php

use App\Http\Controllers\SampleController;
use App\Models\ChildModel;
use App\Models\SampleModel;
use PHPUnit\Framework\TestCase;

class SampleControllerTest extends TestCase
{
    /**
     * @test
     */
    public function testIndexAction()
    {
        $controller = new SampleController();
        $model = new SampleModel(new ChildModel);
        $response = $controller->index($model);

        $this->assertEquals(
            [
                'message' => 'this is index controller',
                'model' => 'SampleModel',
                'child' => 'ChildModel',
            ],
            $response
        );
    }
}