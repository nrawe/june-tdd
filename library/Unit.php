<?php

namespace June\Framework;

use Countable;
use June\Framework\Contracts\Step;

class Unit implements Countable
{
    protected $name;

    protected $steps;

    public function __construct(string $name)
    {
        $this->steps = [];
        $this->name  = $name;
    }

    public function add(Step $step): void
    {
        $this->steps[] = $step;
    }

    public function count(): int
    {
        return count($this->steps);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function steps(): array
    {
        return $this->steps;
    }
}
