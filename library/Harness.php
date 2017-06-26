<?php

namespace June\Framework;

class Harness
{
    /**
     * The path which we should find files in.
     *
     * @var string
     */
    protected $path;

    public function __construct(Loader $loader, Runner $runner)
    {
        $this->loader = $loader;
        $this->runner = $runner;
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
}
