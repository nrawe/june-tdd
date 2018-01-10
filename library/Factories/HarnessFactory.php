<?php

namespace June\Framework\Factories;

use League\CLImate\CLImate;
use June\Framework\Runtime\{Feedback, Loader, Harness, Runner, StepExecutor};

class HarnessFactory
{
    public function get(): Harness
    {
        $feedback = new Feedback(new CLImate);
        $executor = new StepExecutor(new AssertionFactory, $feedback);

        $runner  = new Runner($feedback, $executor);
        $harness = new Harness(new Loader, $runner, new StepFactory);
        $harness->path($argv[1] ?? getcwd() . '/tests');

        return $harness;
    }
}
