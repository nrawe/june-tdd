<?php

namespace June\Framework\Runtime;

use June\Framework\{Suite, Unit};
use June\Framework\Assertions\Exception;
use June\Framework\Cases\{AbstractCase, Bug, Test, Skipped};
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

    protected function executeCase(Unit $unit, AbstractCase $case): bool
    {
        if ($case instanceof Skipped) {
            return true;
        }

        $result = $case->execute();

        if (! $result) {
            $this->printFailure($unit, $case);
        }

        return $result;
    }

    protected function printFailure(Unit $unit, AbstractCase $case)
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
