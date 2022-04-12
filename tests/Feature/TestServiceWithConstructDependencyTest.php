<?php

namespace Tests\Feature;

use App\Services\ExampleDependency;
use App\Services\ExampleServiceWithConstructorDependency;
use Mockery\ExpectationInterface;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TestServiceWithConstructDependencyTest extends TestCase
{
    protected string $mockedReturnText = 'mocked return';
    protected string $path = '/test-service-with-construct-and-dependency';

    public function testWithoutMock(): void
    {
        $this->get($this->path)
            ->assertStatus(Response::HTTP_OK)
            ->assertSee('dependency show');
    }

    public function testWithMock(): void
    {
        $this->app->bind(ExampleServiceWithConstructorDependency::class, function () {
            $mock = $this->getMockBuilder(ExampleServiceWithConstructorDependency::class)
                ->setConstructorArgs(['exampleDependency' => app(ExampleDependency::class)])
                ->getMock();

            $mock->method('render')->willReturn($this->mockedReturnText);

            return $mock;
        });

        $this->get($this->path)
            ->assertStatus(Response::HTTP_OK)
            ->assertSee($this->mockedReturnText);
    }

    public function testWithMockMockingDependency(): void
    {
        $this->app->bind(ExampleServiceWithConstructorDependency::class, function () {

            $dependencyMock = $this->partialMock(ExampleDependency::class);
            $buffer = $dependencyMock->shouldReceive('show');
            /** @var ExpectationInterface $buffer */
            $buffer->andReturn($this->mockedReturnText);

            return $this->getMockBuilder(ExampleServiceWithConstructorDependency::class)
                ->setConstructorArgs(['exampleDependency' => $dependencyMock])
                ->enableProxyingToOriginalMethods() // <- to avoid mocking any methods
                ->getMock();
        });

        $this->get($this->path)
            ->assertStatus(Response::HTTP_OK)
            ->assertSee($this->mockedReturnText);
    }
}
