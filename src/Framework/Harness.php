<?php

namespace June\Framework;

class Harness
{
    protected $reporter;

    protected $stats;

    protected $unit;

    public function __construct(?Reporter $reporter, ?Stats $stats)
    {
        $this->reporter = $reporter;
        $this->stats = $stats;
    }

    public function finish()
    {
        $this->reporter->write($this->stats);
    }

    public function run(Unit $unit)
    {
        $this->reporter->write($unit);

        foreach ($unit->tests as $test) {
            $test->execute();

            $this->reporter->write($test);
            $this->stats->record($test);
        }

        $this->reporter->line();
    }

    public function unit(string $name = ''): Unit
    {
        if ($name) {
            $this->unit = new Unit($name);
        }

        return $this->unit;
    }    
}
