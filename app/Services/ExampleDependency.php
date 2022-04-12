<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class ExampleDependency
{
    public function show(): string
    {
        Log::debug('hey');
        return 'dependency show';
    }
}
