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

    /**
     * Prints the name of the $unit to the user.
     */
    public function unit(Unit $unit): void
    {
        $this->cli
            ->underline()
            ->out($unit->name())
        ;
    }

    /**
     * Prints the name of the $step to the user as a failure.
     */
    public function failedStep(Step $step): void
    {
        $this->cli
            ->bold()
            ->inline(' - ' . $step->name() . ' ')
            ->red()
            ->inline('✗')
        ;
    }

    /**
     * Prints out the exception 
     */
    public function generalError(Step $step, Throwable $ex): void
    {
        $this->unit($step->unit(null));
        $this->failedStep($step);

        $this->cli
            ->tab()
            ->grey(
                $ex->getMessage()
            )
        ;
    }

    public function assertionError(Step $step, AssertionException $ex): void
    {
        $this->generalError($step, $ex);
    }

    public function userError(Step $step, BadUserException $ex): void
    {
        $this->generalError($step, $ex);
    }

    public function suiteProgress(Suite $suite)
    {
        return $this->cli->progress()->total($suite->count());
    }
}
