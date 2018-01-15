<?php

namespace June\Framework\Factories;

use June\Framework\Contracts\Step;
use June\Framework\Steps\{Bug, Skipped, Test};

class StepFactory
{
    public function bug(string $name, callable $body): Step
    {
        return new Bug($name, $body);
    }

    public function test(string $name, callable $body): Step
    {
        return new Test($name, $body);
    }

    public function skipped(string $name, callable $body): Step
    {
        return new Skipped($name, $body);
    }
}
