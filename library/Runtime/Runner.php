<?php

namespace June\Framework\Runtime;

use June\Framework\{Suite, Test, Unit};
use June\Framework\Assertions\Exception;
use League\CLImate\CLImate;
use Throwable;

class Runner
{
    public function __construct(CLImate $cli)
    {
        $this->cli = $cli;
    }

    public function run(Suite $suite): bool
    {
        $progress = $this->cli->progress()->total($suite->count());
        
        foreach ($suite->units() as $unit) {
            foreach ($unit->cases() as $case) {
                $progress->advance(1);

                if (! $this->executeCase($unit, $case)) {
                    return false;
                }
            }
        }

        return true;
    }

    protected function executeCase(Unit $unit, Test $case): bool
    {
        if (! $case->canExecute()) {
            return true;
        }

        $result = $case->execute();

        if (! $result) {
            $this->printFailure($unit, $case);
        }

        return $result;
    }

    protected function printFailure(Unit $unit, Test $case)
    {
        $this->cli
             ->underline()
             ->out($unit->name())
        ;

        $this->cli
             ->bold()
             ->inline(' - ' . $case->name() . ' ')
             ->red()
             ->inline('✗')
        ;

        $f = $case->failure();

        $this->cli
             ->tab()
             ->grey(
                 $f instanceof Exception ? $f->getMessage () : $f
             )
        ;
    }
}
