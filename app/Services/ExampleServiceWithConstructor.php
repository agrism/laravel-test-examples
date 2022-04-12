<?php

namespace App\Services;

class ExampleServiceWithConstructor
{
    protected string $message = 'msg not set';

    public function __construct(string $message)
    {
        $this->setMessage($message);
    }

    public function render(): string
    {
        return $this->message;
    }

    protected function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
