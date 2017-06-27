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

    public function __invoke($subject, $expectation)
    {
        if ($this->assertion->passes($subject, $expectation)) {
            return;
        }

        throw new Exception($this->message($subject, $expectation));
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

    protected function message($subject, $expectation): string
    {
        return str_replace(
            ['%subject', '%expectation'],
            [$subject, $expectation],
            $this->assertion->message()
        );
    }
}
