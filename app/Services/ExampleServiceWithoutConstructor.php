<?php

namespace App\Services;

class ExampleServiceWithoutConstructor
{
    protected string $message = 'msg not set';

    public function render(): string
    {
        return $this->prepareMessage()->message;
    }

    protected function prepareMessage(): self
    {
        $this->setMessage('msg native set');

        return $this;
    }

    protected function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
