<?php

namespace June\Framework;

use Countable;
use June\Framework\Contracts\Step;

/**
 * A Unit represents a class that needs to be tested.
 * 
 * It is comprised of a series of Steps which comprise the actual steps.
 */
class Unit implements Countable
{
    /**
     * The name of the Unit being tested.
     * 
     * @var string
     */
    protected $name;

    /**
     * The Steps which comprise the Unit.
     * 
     * @var Step[]
     */
    protected $steps = [];

    public function __construct(string $name)
    {
        $this->name  = $name;
    }

    /**
     * Adds a Step into the Unit.
     */
    public function add(Step $step): void
    {
        $this->steps[] = $step;
    }

    /**
     * Returns the number of Steps that have been added to the Unit.
     */
    public function count(): int
    {
        return count($this->steps);
    }

    /**
     * Returns the name of the Unit.
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Returns an array of Steps which the Unit is comprised of.
     */
    public function steps(): array
    {
        return $this->steps;
    }
}
