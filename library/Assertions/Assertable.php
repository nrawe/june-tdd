<?php

namespace June\Framework\Assertions;

use June\Framework\Assertions\AssertionException;

trait Assertable
{
    public function __invoke($subject, $expectation)
    {
        $this->test($subject, $expectation);
    }

    protected function test($subject, $expectation)
    {
        if (! $this->passes($subject, $expectation)) {
            throw new AssertionException($this, $subject, $expectation);
        }
    }
}
