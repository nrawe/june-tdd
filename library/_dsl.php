<?php

namespace June;

use June\Framework\Runtime\Harness;
use RuntimeException;
use June\Framework\Factories\HarnessFactory;

function harness(): Harness
{
    static $instance;

    if (! $instance) {
        $instance = (new HarnessFactory)->get();
    }

    return $instance;
}

function bug(string $name, callable $case)
{
    harness(null)->test($name, $case);
}

function debug(array $context = [])
{
    \Psy\debug($context);
}

function test(string $name, callable $case)
{
    harness()->test($name, $case);
}

function unit(string $name, callable $tests)
{
    harness()->unit($name);

    $tests();
}

function xbug(string $name, callable $case)
{
    harness()->skipped($name, $case);
}

function xtest(string $name, callable $case)
{
    harness()->skipped($name, $case);
}
