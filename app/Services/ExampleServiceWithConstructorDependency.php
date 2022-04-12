<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class ExampleServiceWithConstructorDependency
{
    protected ExampleDependency $exampleDependency;

    protected string $message;

    public function __construct(ExampleDependency $exampleDependency)
    {
        $this->exampleDependency = $exampleDependency;

        $this->composeMessage();
    }

    public function render(): string
    {
        return $this->message;
    }

    protected function composeMessage(): self
    {
        $this->message = $this->exampleDependency->show();

        return $this;
    }


}
