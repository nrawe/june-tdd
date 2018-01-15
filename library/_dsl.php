<?php

namespace June;

use June\Framework\Factories\HarnessFactory;
use June\Framework\Runtime\Harness;
use RuntimeException;

/**
 * Returns the current harness instance.
 */
function harness(): Harness
{
    static $instance;

    if (! $instance) {
        $instance = (new HarnessFactory)->get();
    }

    return $instance;
}

/**
 * Registers a testing step in the form of a bug.
 * 
 * Bug steps are semantically differentiated from tests to separate out
 * design from reality.
 * 
 * The $step callback will be executed when the framework reaches the step.
 */
function bug(string $name, callable $steps)
{
    harness(null)->bug($name, $steps);
}

/**
 * Registers a testing step in the form of a test.
 * 
 * Test steps are semantically differentiated from bugs to separate out
 * reality from design.
 * 
 * The $step callback will be executed when the framework reaches the step.
 */
function test(string $name, callable $steps)
{
    harness()->test($name, $steps);
}

/**
 * When `psy/psysh` is installed, this function can be used to drop into a
 * terminal to debug failing test steps.
 */
function tinker(array $context = [])
{
    \Psy\debug($context);
}

/**
 * Registers a unit to be tested.
 * 
 * The $tests callback will be invoked immediately and should in turn register
 * any required test steps for the unit with the framework.
 */
function unit(string $name, callable $tests)
{
    harness()->unit($name);

    $tests();
}

/**
 * Registers a disabled testing step in the form of a bug.
 * 
 * Bug steps are semantically differentiated from tests to separate out
 * design from reality.
 * 
 * The $step callback will not be executed and as such this helper can be used
 * to temporarily disable a failing test step.
 */
function xbug(string $name, callable $steps)
{
    harness()->skipped($name, $steps);
}

/**
 * Registers a disabled testing step in the form of a test.
 * 
 * Test steps are semantically differentiated from bugs to separate out
 * reality from design.
 * 
 * The $step callback will not be executed and as such this helper can be used
 * to temporarily disable a failing test step.
 */
function xtest(string $name, callable $steps)
{
    harness()->skipped($name, $steps);
}
