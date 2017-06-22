<?php

namespace June\Framework;

/**
 * Handles the comparison of values.
 *
 * The class operates as a function which executes the actual comparison when
 * called.
 */
class Assertion
{
    /**
     * The name of the assertion to be called.
     *
     * @var string
     */
    protected $name;

    /**
     * Creates a new instance of the assertion, taking in the name of the
     * assertion to be run when the class is invoked.
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Calls the assertion.
     */
    public function __invoke(...$args)
    {
        call_user_func_array([$this, $this->name], $args);
    }

    /**
     * Handles the actual assertion, throwing an AssertionException in the
     * instance that the condition is false.
     */
    protected function assert(bool $condition)
    {
        if (! $condition) {
            throw new AssertionException();
        }
    }

    /**
     * Compares arguments for equality.
     */
    protected function equal($a, $b)
    {
        $this->assert($a === $b);
    }

    /**
     * Compares arguments for inequality.
     */
    protected function unequal($a, $b)
    {
        $this->assert($a !== $b);
    }
}
