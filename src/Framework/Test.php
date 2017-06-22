<?php

namespace June\Framework;

class Test
{
    const BUG = 1;
    const TEST = 2;
    const SKIPPED = 4;

    public $callback;
    public $name;
    public $success;
    public $type;

    public function __construct(string $name, callable $callback, int $type)
    {
        $this->callback = $callback;
        $this->name = $name;
        $this->success = false;
        $this->type = $type;
    }

    public function execute(): bool
    {
        return $this->success = (new TestExecutor($this->callback))->execute();
    }

    public function isBug(): bool
    {
        return $this->type & Test::BUG;
    }

    public function isTest(): bool
    {
        return $this->type & Test::TEST; 
    }

    public function isSkipped(): bool
    {
        return $this->type & Test::SKIPPED;
    }    
}
