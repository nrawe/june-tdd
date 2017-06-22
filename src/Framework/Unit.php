<?php

namespace June\Framework;

class Unit
{
    public $name;
    public $tests = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function add(Test $test)
    {
        $this->tests[] = $test;
    }
}
