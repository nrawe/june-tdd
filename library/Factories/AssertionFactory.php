<?php

namespace June\Framework\Factories;

use June\Framework\Assertions\{Equal, Unequal};
use June\Framework\Contracts\Assertion;
use June\Framework\Exceptions\BadUserException;

/**
 * The AssertionFactory provides a lookup service for returning Assertion
 * instances.
 */
class AssertionFactory
{
    /**
     * A registry of all of the available assertions that can be used during
     * testing.
     */
    const AVAILABLE = [
        Equal::class,
        Unequal::class,
    ];

    /**
     * A map of instantiated assertion instances.
     * 
     * We keep these instances loaded for improved performance on longer test
     * runs.
     */
    protected static $cache = [];


    //region Public API

    /**
     * Returns an instance of an Assertion by its $name.
     * 
     * If the Assertion could not be found, null will be returned instead.
     */
    public function find(string $name): ?Assertion
    {
        foreach ($this::AVAILABLE as $assertion) {
            $instance = $this->makeAssertion($assertion);

            if ($instance->name() === $name) {
                return $instance;
            }
        }

        return null;
    }

    /**
     * Returns an instance of an Assertion by its $name.
     * 
     * If the Assertion could not be found, a BadUserException will be thrown
     * instead.
     */
    public function findOrFail(string $name): Assertion
    {
        $assertion = $this->find($name);

        if (! $assertion) {
            throw BadUserException::new(
                BadUserException::UNKNOWN_ASSERTION, ['name' => $name]
            );
        }

        return $assertion;
    }

    /**
     * Removes any Assertion instances that have been cached from memory.
     */
    public function resetCachedAssertions()
    {
        self::$cache = [];
    }

    //endregion


    //region Internal API

    protected function cacheAssertion(string $assertion, Assertion $instance): void
    {
        self::$cache[$assertion] = $instance;
    }

    protected function isAssertionCached(string $assertion): bool
    {
        return array_key_exists($assertion, self::$cache);
    }

    protected function makeAssertion(string $assertion): Assertion
    {
        if (! $this->isAssertionCached($assertion)) {
            $this->cacheAssertion($assertion, new $assertion);
        }

        return $this->yeildCachedAssertion($assertion);
    }

    protected function yeildCachedAssertion(string $assertion): Assertion
    {
        return self::$cache[$assertion];
    }

    //endregion
}
