<?php

namespace June\Framework\Assertions;

use June\Framework\Contracts\Assertion;
use function June\Framework\parameterise_string;

/**
 * An AssertionException is thrown when a given condition fails to meet the
 * stated expectations.
 */
class AssertionException extends \Exception
{
    /**
     * Returns a new AssertionException configured with the failure message
     * from the given $assertion, taking account of the failing $subject and
     * $expectation.
     */
    public static function new(Assertion $assertion, $subject, $expectation): AssertionException
    {
        return new static(parameterise_string(
            $assertion->message(), compact('subject', 'expectation')
        ));
    }
}
