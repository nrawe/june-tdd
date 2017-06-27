<?php

namespace June\Framework\Assertions;

class Unequal implements Contract
{
    public function message(): string
    {
        return '%subject === %expectation';
    }

    public function name(): string
    {
        return 'unequal';
    }

    public function passes($subject, $expectation): bool
    {
        return $subject !== $expectation;
    }
}
