<?php

namespace June;

use Illuminate\Container\Container;
use June\Framework\Harness;
use June\Framework\Test;

function debug(array $context = [])
{
    \Psy\debug($context);
}

function bug(string $name, callable $test)
{
    $test = new Test($name, $test, Test::BUG);

    harness()->unit()->add($test);
}

function harness()
{
    static $instance;

    if (! $instance) {
        $instance = Container::getInstance()->make(Harness::class);
    }

    return $instance;
}

function test(string $name, callable $test)
{
    $test = new Test($name, $test, Test::TEST);

    harness()->unit()->add($test);
}

function unit(string $name, callable $tests)
{
    $unit = harness()->unit($name);

    $tests();

    harness()->run($unit);
}

function xbug(string $name, callable $test)
{
    $test = new Test($name, $test, Test::BUG | Test::SKIPPED);

    harness()->unit()->add($test);
}

function xtest(string $name, callable $test)
{
    $test = new Test($name, $test, Test::TEST | Test::SKIPPED);

    harness()->unit()->add($test);
}
