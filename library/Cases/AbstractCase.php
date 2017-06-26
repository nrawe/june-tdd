<?php

namespace June\Framework\Cases;

use June\Framework\Assertions\Assertion;
use ReflectionFunction;
use Throwable;

class AbstractCase
{
    protected $case;

    protected $failure;

    protected $name;

    public function __construct(string $name, callable $case)
    {
        $this->case = $case;
        $this->name = $name;
    }

    public function execute(): bool
    {
        try {
            ($this->case)(...$this->assertions());
        } catch (Throwable $t) {
            $this->failure = $t;
        }
        
        return !$this->failure;
    }

    public function failure(): ?Throwable
    {
        return $this->failure;
    }

    public function name(): string
    {
        return $this->name;
    }

    protected function assertions(): array
    {
        $assertions = [];
        $reflection = new ReflectionFunction($this->case);

        foreach ($reflection->getParameters() as $parameter) {
            $assertions[] = new Assertion($parameter->getName());
        }

        return $assertions;
    }
}
