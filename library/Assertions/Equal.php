<?php

namespace June\Framework\Assertions;

class Equal implements Contract
{
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
