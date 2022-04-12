<?php

use Illuminate\Support\Facades\Route;
use App\Services\ExampleServiceWithoutConstructor;
use App\Services\ExampleServiceWithConstructor;
use App\Services\ExampleServiceWithConstructorDependency;
use App\Services\ExampleDependency;

Route::get('/test-service-without-construct', function () {
    return app(ExampleServiceWithoutConstructor::class)->render();
});

Route::get('/test-service-with-construct', function () {
    return app(ExampleServiceWithConstructor::class, [
        'message' => 'msg native set'
    ])->render();
});

Route::get('/test-service-with-construct-and-dependency', function () {
    return app(ExampleServiceWithConstructorDependency::class, [
        'exampleDependency' => app(ExampleDependency::class
        )])->render();
});

Route::get('/', function () {
    return view('welcome');
});
