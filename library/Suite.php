<?php

namespace June\Framework;

use Countable;

/**
 * A Suite stores Units that have been registered for testing.
 */
class Suite implements Countable
{
    /**
     * Stores the units which have been registered during the loading of the
     * test files.
     * 
     * @var Unit
     */
    protected $units = [];

    /**
     * Returns information about the suite for use in debugging.
     */
    public function __debugInfo(): array
    {
        return [
            'count' => $this->count(),
            'units' => $this->units,
        ];
    }

    /**
     * Registers a Unit instance with the Suite.
     */
    public function add(Unit $unit): void
    {
        $this->units[] = $unit;
    }

    /**
     * Returns the count of the number of tests that have been registered.
     */
    public function count(): int
    {
        $count = 0;

        foreach ($this->units as $unit) {
            $count += $unit->count();
        }

        return $count;
    }

    /**
     * Returns the Units which have been registered with the Suite.
     */
    public function units(): array
    {
        return $this->units;
    }
}
