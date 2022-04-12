## Testable cases:

- test Services without __construct
- test Services with __construct
- test Services with __construct dependencies

### code:

```php
use Illuminate\Support\Facades\Route;
use App\Services\ExampleServiceWithoutConstructor;
use App\Services\ExampleServiceWithConstructor;
use App\Services\ExampleServiceWithConstructorDependency;
use App\Services\ExampleDependency;

Route::get('/test-service-without-construct', function () {
    // case 1
    return app(ExampleServiceWithoutConstructor::class)->render();
});

Route::get('/test-service-with-construct', function () {
    // case 2
    return app(ExampleServiceWithConstructor::class, [
        'message' => 'msg native set'
    ])->render();
});

Route::get('/test-service-with-construct-and-dependency', function () {
    // case 3
    return app(ExampleServiceWithConstructorDependency::class, [
        'exampleDependency' => app(ExampleDependency::class
        )])->render();
});
```

### test examples:

Case 1. [Tests Service without constructor](./tests/Feature/TestServiceWithoutConstructTest.php)

Case 2. [Tests Service with constructor](./tests/Feature/TestServiceWithConstructTest.php)

Case 3. [Tests Service with dependency in constructor](./tests/Feature/TestServiceWithConstructDependencyTest.php)
