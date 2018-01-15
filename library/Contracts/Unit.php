<?php

namespace June\Framework\Contracts;

interface Unit
{
    /**
     * Adds a Step into the Unit.
     */
    public function add(Step $step): void;

    /**
     * Returns the number of Steps that have been added to the Unit.
     */
    public function count(): int;

    /**
     * Returns the name of the Unit.
     */
    public function name(): string;

    /**
     * Returns an array of Steps which the Unit is comprised of.
     */
    public function steps(): array;
}
