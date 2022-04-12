## Testable cases:

### 1. Service without constructor
```php
Route::get('/test-service-without-construct', function () {
    return app(ExampleServiceWithoutConstructor::class)->render();
});
```
Tests: [Tests Service without constructor](./tests/Feature/TestServiceWithoutConstructTest.php)


### 2. Service with constructor
```php
Route::get('/test-service-with-construct', function () {
    return app(ExampleServiceWithConstructor::class, [
        'message' => 'msg native set'
    ])->render();
});
````
Tests: [Tests Service with constructor](./tests/Feature/TestServiceWithConstructTest.php)


### 3. Service with dependency in constructor
```php
Route::get('/test-service-with-construct-and-dependency', function () {
    return app(ExampleServiceWithConstructorDependency::class, [
        'exampleDependency' => app(ExampleDependency::class)
    ])->render();
});
```
Tests: [Tests Service with dependency in constructor](./tests/Feature/TestServiceWithConstructDependencyTest.php)
