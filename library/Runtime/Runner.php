<?php

namespace June\Framework\Runtime;

use June\Framework\{Suite, Test, Unit};

class Runner
{
    /**
     * @var StepExecutor
     */
    protected $executor;

    /**
     * @var Feedback
     */
    protected $feedback;

    public function __construct(Feedback $feedback, StepExecutor $executor)
    {
        $this->feedback = $feedback;
        $this->executor = $executor;
    }

    public function run(Suite $suite): bool
    {
        $progress = $this->feedback->suiteProgress($suite);
        
        foreach ($suite->units() as $unit) {
            foreach ($unit->steps() as $step) {
                $progress->advance(1);

                if (! $this->executor->execute($unit, $step)) {
                    return false;
                }
            }
        }

        return true;
    }
}
