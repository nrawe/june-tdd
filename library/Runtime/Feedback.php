<?php

namespace June\Framework\Runtime;

use June\Framework\Assertions\AssertionException;
use June\Framework\Contracts\Step;
use June\Framework\{Suite, Unit};
use League\CLImate\CLImate;
use Throwable;
use June\Framework\Exceptions\BadUserException;

/**
 * Feedback provides an abstraction over information presented to the user.
 */
class Feedback
{
    /**
     * The CLImate instance used for colourising output.
     * 
     * @var CLImate
     */
    protected $cli;

    public function __construct(CLImate $cli)
    {
        $this->cli = $cli;
    }

    public function unit(Unit $unit): void
    {
        $this->cli
            ->underline()
            ->out($unit->name())
        ;
    }

    public function failedStep(Step $step): void
    {
        $this->cli
            ->bold()
            ->inline(' - ' . $step->name() . ' ')
            ->red()
            ->inline('✗')
        ;
    }

    public function generalError(Unit $unit, Step $step, Throwable $ex): void
    {
        $this->unit($unit);
        $this->failedStep($step);

        $this->cli
            ->tab()
            ->grey(
                $ex->getMessage()
            )
        ;
    }

    public function assertionError(Unit $unit, Step $step, AssertionException $ex): void
    {
        $this->generalError($unit, $step, $ex);
    }

    public function userError(Unit $unit, Step $step, BadUserException $ex): void
    {
        $this->generalError($unit, $step, $ex);
    }

    public function suiteProgress(Suite $suite)
    {
        return $this->cli->progress()->total($suite->count());
    }
}
