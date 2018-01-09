<?php

namespace June\Framework\Contracts;

interface Step
{
    /**
     * Returns the callable function that represents the users test.
     */
    public function body(): callable;

    /**
     * Returns whether the step can be executed by a Runner.
     */
    public function isExecutable(): bool;

    /**
     * Returns the name of the step for showing to the user if execution
     * fails.
     */
    public function name(): string;
}
