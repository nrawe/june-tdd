<?php

namespace June\Framework;

class Reporter
{
    public function line(string $text = '')
    {
        echo $text . PHP_EOL;
    }

    public function write($object): void
    {
        switch (get_class($object)) {
            case Unit::class:
                $this->unit($object);
                break;

            case Test::class:
                $this->test($object);
                break;

            case Stats::class:
                $this->stats($object);
                break;
        }
    }

    protected function stats(Stats $stats): void
    {

    }

    protected function test(Test $test): void
    {
        $prefix = $test->isBug() ? 'Bug: ' : '';
        $suffix = $test->success ? '✓' : '✗';

        $this->line(' - ' . $prefix . $test->name . ' ' . $suffix);
    }

    protected function unit(Unit $unit): void
    {
        $this->line($unit->name . ':');
    }
}
