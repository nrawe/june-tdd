<?php

namespace June\Framework\Factories;

use League\CLImate\CLImate;
use June\Framework\Runtime\{Feedback, Loader, Harness, Runner, StepExecutor};

class HarnessFactory
{
    public function get(): Harness
    {
        $feedback = new Feedback(new CLImate);

        $runner  = new Runner(new AssertionFactory, $feedback);
        $harness = new Harness(new Loader, $runner, new StepFactory);
        $harness->path($_SERVER['argv'][1] ?? getcwd() . '/tests');

        return $harness;
    }
}
