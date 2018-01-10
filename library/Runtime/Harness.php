<?php

namespace June\Framework\Runtime;

use June\Framework\{SkippedTest, Suite, Test, Unit};
use June\Framework\Factories\StepFactory;

class Harness
{
    /**
     * The path which we should find files in.
     *
     * @var string
     */
    protected $path;

    /**
     * @var StepFactory
     */
    protected $steps;

    public function __construct(Loader $loader, Runner $runner, StepFactory $steps)
    {
        $this->loader = $loader;
        $this->runner = $runner;
        $this->steps = $steps;
        $this->suite  = new Suite();
    }

    public function path(string $path)
    {
        $this->path = $path;
    }

    public function run(): int
    {
        $this->loader->load($this->path);

        return $this->runner->run($this->suite) ? -1 : 0;
    }

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

    public function test(string $name, callable $body)
    {
        $this->unit()->add($this->steps->test($name, $body));
    }

    public function skipped(string $name, callable $body)
    {
        $this->unit()->add($this->steps->skipped($name, $body));
    }
}
