<?php

namespace June\Framework;

use ReflectionFunction;

class TestExecutor
{
    protected $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function execute(): bool
    {
        try {
            call_user_func_array(
                $this->callback, $this->assertions()
            );

            return true;

        } catch (AssertionException $e) {
            return false;
        }
    }

    protected function assertions()
    {
        $assertions = [];
        $reflection = new ReflectionFunction($this->callback);

        foreach ($reflection->getParameters() as $parameter) {
            $assertions[] = new Assertion($parameter->getName());
        }

        return $assertions;
    }
}
