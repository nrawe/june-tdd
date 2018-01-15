<?php

namespace June\Framework\Assertions;

use June\Framework\Contracts\Assertion;

class Equal implements Assertion
{
    use Assertable;

    public function message(): string
    {
        return '%subject !== %expectation';
    }

    public function name(): string
    {
        return 'equal';
    }

    public function passes($subject, $expectation): bool
    {
        return $subject === $expectation;
    }
}
