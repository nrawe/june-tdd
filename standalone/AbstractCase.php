<?php

namespace June\Framework;

use ReflectionFunction;

class AbstractCase
{
    protected $case;

    protected $name;

    public function __construct(string $name, callable $case)
    {
        $this->case = $case;
        $this->name = $name;
    }

    public function execute()
    {
        try {
            $case = $this->case;
            $case(...$this->assertions());

            $this->pass();

        } catch (AssertionException $e) {
            $this->fail($e);
        }
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

    protected function pass()
    {
        echo ' - ', $this->name, ' ✓', PHP_EOL;
    }

    protected function fail()
    {
        echo ' - ', $this->name, ' ✗', PHP_EOL;
    }
}
