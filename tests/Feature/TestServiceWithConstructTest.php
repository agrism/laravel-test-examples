<?php

namespace Tests\Feature;

use App\Services\ExampleServiceWithConstructor;
use Symfony\Component\HttpFoundation\Response;
use App\Services\ExampleServiceWithoutConstructor;
use Tests\TestCase;

class TestServiceWithConstructTest extends TestCase
{
    protected string $mockedReturnText = 'mocked return';
    protected string $path = '/test-service-with-construct';


    public function testWithoutMock(): void
    {
        $this->get($this->path)
            ->assertStatus(Response::HTTP_OK)
            ->assertSee('msg native set');
    }

    public function testWithMockDisablingConstructor(): void
    {
        $this->app->bind(ExampleServiceWithConstructor::class, function () {
            $mock = $this->getMockBuilder(ExampleServiceWithConstructor::class)
                ->disableOriginalConstructor()
                ->getMock();

            $mock->method('render')->willReturn($this->mockedReturnText);

            return $mock;
        });

        $this->get($this->path)
            ->assertStatus(Response::HTTP_OK)
            ->assertSee($this->mockedReturnText);
    }

    public function testWithMockUsingConstructor(): void
    {
        $this->app->bind(ExampleServiceWithConstructor::class, function () {
            $mock = $this->getMockBuilder(ExampleServiceWithConstructor::class)
                ->setConstructorArgs(['message' =>'I do not care what I pass here'])
                ->getMock();

            $mock->method('render')->willReturn($this->mockedReturnText);

            return $mock;
        });

        $this->get($this->path)
            ->assertStatus(Response::HTTP_OK)
            ->assertSee($this->mockedReturnText);
    }

}
