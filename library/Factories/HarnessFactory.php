<?php

namespace June\Framework\Factories;

use League\CLImate\CLImate;
use June\Framework\Runtime\{Loader, Harness, Runner};

class HarnessFactory
{
    public function get(): Harness
    {
        $runner  = new Runner(new CLImate);
        $harness = new Harness(new Loader, $runner);
        $harness->path($argv[1] ?? getcwd() . '/tests');

        return $harness;
    }
}
