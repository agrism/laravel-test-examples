<?php

namespace Tests\Feature;

use Symfony\Component\HttpFoundation\Response;
use App\Services\ExampleServiceWithoutConstructor;
use ReflectionClass;
use Tests\TestCase;

class TestServiceWithoutConstructTest extends TestCase
{
    protected string $mockedReturnText = 'mocked return';
    protected string $path = '/test-service-without-construct';

    public function testWithoutMock(): void
    {
        $this->get($this->path)
            ->assertStatus(Response::HTTP_OK)
            ->assertSee('msg native set');
    }

    public function testWithMock(): void
    {
        $this->app->bind(ExampleServiceWithoutConstructor::class, function () {
            return $this->mock(ExampleServiceWithoutConstructor::class, function ($mock) {
                $mock->makePartial();
                $mock->shouldReceive('render')->andReturn($this->mockedReturnText);
            });
        });

        $this->get($this->path)
            ->assertStatus(Response::HTTP_OK)
            ->assertSee($this->mockedReturnText);
    }

    public function testProtectedMethodAndDoSomeActionsWhenMethodIsTriggered(): void
    {
        $this->app->bind(ExampleServiceWithoutConstructor::class, function () {
            return $this->mock(ExampleServiceWithoutConstructor::class, function ($mock) {
                $mock->shouldAllowMockingProtectedMethods()->makePartial();
                $mock->shouldReceive('prepareMessage')->andReturnUsing(function() use($mock){
                    $reflection = new ReflectionClass($mock);
                    $reflectionProperty = $reflection->getProperty('message');
                    $reflectionProperty->setAccessible(true);
                    $reflectionProperty->setValue($mock, $this->mockedReturnText);
                    return  $mock;
                });
            });
        });

        $this->get($this->path)
            ->assertStatus(Response::HTTP_OK)
            ->assertSee($this->mockedReturnText);
    }
}
