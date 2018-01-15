<?php

namespace June\Framework\Contracts;

interface Assertion
{
    /**
     * Returns the message string which will be presented to the user when an
     * assertion fails to pass.
     * 
     * This message can contain two parameters:
     * 
     * - %subject
     * - %expectation
     * 
     * See `passes()` for more details.
     */
    public function message(): string;

    /**
     * Returns the name of the Assertion when used in parameter injection.
     */
    public function name(): string;

    /**
     * Returns whether the given $subject meets the required $expectation.
     */
    public function passes($subject, $expectation): bool;
}
