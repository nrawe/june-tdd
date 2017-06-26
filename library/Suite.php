<?php

namespace June\Framework;

use Countable;

class Suite implements Countable
{
    protected $units;

    public function __construct()
    {
        $this->units = [];
    }

    public function __debugInfo(): array
    {
        return [
            'count' => $this->count(),
            'units' => $this->units,
        ];
    }

    public function add(Unit $unit): void
    {
        $this->units[] = $unit;
    }

    public function count(): int
    {
        $count = 0;

        foreach ($this->units as $unit) {
            $count += $unit->count();
        }

        return $count;
    }

    public function units(): array
    {
        return $this->units;
    }
}
