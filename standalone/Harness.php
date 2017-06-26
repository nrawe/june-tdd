<?php

namespace June\Framework;

use Throwable;

class Harness
{
    /**
     * The path which we should find files in.
     *
     * @var string
     */
    protected $path;

    public function __construct(Loader $loader)
    {
        $this->loader = $loader;
    }

    public function path(string $path)
    {
        $this->path = $path;
    }

    public function run(): int
    {
        $t = null;

        try {
            $this->loader->load($this->path);

        } catch (Throwable $t) {
            echo $t->getMessage(), PHP_EOL;
        }

        return $t ? -1 : 0;
    }
}
