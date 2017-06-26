<?php

namespace June\Framework\Assertions;

use InvalidArgumentException;

class Assertion
{
    protected static $availableAssertions = [
        Equal::class,
        Unequal::class,
    ];

    public function __construct(string $name)
    {
        $assertion = $this->findAssertion($name);

        if (! $assertion) { 
            throw new InvalidArgumentException(
                'Unknown assertion "' . $name . '"'
            );
        }

        $this->assertion = $assertion;
    }

    public function __invoke($a, $b)
    {
        if ($this->assertion->passes($a, $b)) {
            return;
        }

        throw new Exception($this->message($a, $b));
    }

    protected function findAssertion(string $name): ?Contract
    {
        foreach (self::$availableAssertions as $assertion) {
            $instance = new $assertion;

            if ($instance->name() === $name) {
                return $instance;
            }
        }
    }

    protected function message($a, $b): string
    {
        return str_replace(
            ['%a', '%b'], [$a, $b], $this->assertion->message()
        );
    }
}
