<?php

namespace June\Framework;

use Countable;
use June\Framework\Cases\AbstractCase;

class Unit implements Countable
{
    protected $name;

    protected $cases;

    public function __construct(string $name)
    {
        $this->cases = [];
        $this->name  = $name;
    }

    public function add(AbstractCase $case): void
    {
        $this->cases[] = $case;
    }

    public function cases(): array
    {
        return $this->cases;
    }

    public function count(): int
    {
        return count($this->cases);
    }

    public function name(): string
    {
        return $this->name;
    }
}
