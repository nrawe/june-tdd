<?php

namespace June\Framework\Runtime;

use June\Framework\{Suite, Unit};
use June\Framework\Contracts\Step;
use June\Framework\Exceptions\BadUserException;
use June\Framework\Factories\StepFactory;
use RuntimeException;

/**
 * Handles the loading and running of tests.
 */
class Harness
{
    /**
     * The mechanism to load in test files by.
     * 
     * @var Loader
     */
    protected $loader;

    /**
     * The path which we should find files in.
     *
     * @var string
     */
    protected $path;

    /**
     * The mechanism to execute the test files by.
     * 
     * @var Runner
     */
    protected $runner;
    
    /**
     * The factory for returning Step objects.
     * 
     * @var StepFactory
     */
    protected $steps;

    /**
     * The Suite which will receive all of the Units and Steps.
     * 
     * @var Suite
     */
    protected $suite;

    public function __construct(Loader $loader, Runner $runner, StepFactory $steps)
    {
        $this->loader = $loader;
        $this->runner = $runner;
        $this->steps = $steps;
        $this->suite  = new Suite();
    }

    /**
     * Sets the path for loading tests from.
     */
    public function path(string $path)
    {
        $this->path = $path;
    }

    /**
     * Executes the tests.
     */
    public function run(): int
    {
        $this->loader->load($this->path);

        return $this->runner->run($this->suite) ? -1 : 0;
    }

    /**
     * Registers a skipped test step.
     */
    public function skipped(string $name, callable $body)
    {
        $step = $this->steps->skipped($name, $body);

        $this->tryAddingToUnit($step);
    }

    /**
     * Registers a test step.
     */
    public function test(string $name, callable $body)
    {
        $step = $this->steps->test($name, $body);

        $this->tryAddingToUnit($step);   
    }

    /**
     * Registers a Unit.
     */
    public function unit(string $unit = ''): Unit
    {
        if ($unit) {
            $this->unit = new Unit($unit);
            $this->suite->add($this->unit);
        }

        if (! $this->unit) {
            throw new RuntimeException('No currently active unit');
        }

        return $this->unit;
    }

    /**
     * Attempts to register a Step with the current Unit.
     */
    protected function tryAddingToUnit(Step $step)
    {
        try {
            $this->unit()->add($step);
        } catch (RuntimeException $ex) {
            throw BadUserException::new(
                BadUserException::UNIT_NOT_REGISTERED, ['name' => $step->name()]
            );
        }
    }
}
