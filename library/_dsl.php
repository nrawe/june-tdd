<?php

namespace June;

use June\Framework\Runtime\Harness;
use June\Framework\Cases\{Bug, Test, Skipped};
use RuntimeException;

function harness(?Harness $harness): Harness
{
    static $instance;
    
    if ($harness) {
        $instance = $harness;
    }

    if (! $instance) {
        throw new RuntimeException('No harness instance defined');
    }

    return $instance;
}

function bug(string $name, callable $case)
{
    harness(null)->unit()->add(new Bug($name, $case));
}

function debug(array $context = [])
{
    \Psy\debug($context);
}

function test(string $name, callable $case)
{
    harness(null)->unit()->add(new Test($name, $case));
}

function unit(string $name, callable $tests)
{
    harness(null)->unit($name);

    $tests();
}

function xbug(string $name, callable $case)
{
    harness(null)->unit()->add(new Skipped($name, $case));
}

function xtest(string $name, callable $case)
{
    harness(null)->unit()->add(new Skipped($name, $case));
}
