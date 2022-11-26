<?php

use App\Foundation\Http\Routing\Route;
use App\Http\Controllers\SampleController;

return [
    Route::get('/sample', SampleController::class, 'index'),
    Route::get('/sample/update', SampleController::class, 'update'),
];