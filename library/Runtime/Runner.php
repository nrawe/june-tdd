<?php

namespace June\Framework\Runtime;

use June\Framework\{Suite, Unit};
use June\Framework\Contracts\Step;
use June\Framework\Factories\AssertionFactory;
use June\Framework\Exceptions\{AssertionException, BadUserException};
use ReflectionFunction;
use Throwable;

/**
 * Handles the execution of all of the tests contained in a Suite.
 */
class Runner
{
    /**
     * Handler for returning assertions.
     * 
     * @var AssertionFactory
     */
    protected $assertions;

    /**
     * The user feedback for handling output.
     * 
     * @var Feedback
     */
    protected $feedback;

    public function __construct(AssertionFactory $assertions, Feedback $feedback)
    {
        $this->assertions = $assertions;
        $this->feedback = $feedback;
    }

    /**
     * Executes the tests contained in the Suite.
     */
    public function run(Suite $suite): bool
    {
        $this->feedback->version();

        $progress = $this->feedback->suiteProgress($suite);
        
        foreach ($suite->units() as $unit) {
            foreach ($unit->steps() as $step) {
                $progress->advance(1);

                if (! $this->execute($step)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Attempts to execute the Step.
     */
    protected function attempt(Step $step): bool
    {
        if (! $step->isExecutable()) {
            return true;
        }

        return $this->attemptBody($step->body());
    }

    /**
     * Attempts to execute the body of the Step.
     */
    protected function attemptBody(callable $body): bool
    {
        $assertions = $this->findAssertionsForBody($body);

        $body(...$assertions);

        return true;
    }

    /**
     * Co-ordinates execution of the Step.
     */
    protected function execute(Step $step): bool
    {
        try {
            return $this->attempt($step);

        } catch (AssertionException $assertion) {
            $this->feedback->assertionError($step, $assertion);

        } catch (BadUserException $user) {
            $this->feedback->userError($step, $user);

        } catch (Throwable $thrown) {
            $this->feedback->generalError($step, $thrown);
        }

        return false;
    }

    /**
     * Reads the signature of the callback function and returns the assertions
     * that need to be injected.
     */
    protected function findAssertionsForBody(callable $body): array
    {
        $assertions = [];
        $reflection = new ReflectionFunction($body);

        foreach ($reflection->getParameters() as $parameter) {
            $assertions[] = $this->assertions->findOrFail($parameter->getName());
        }

        return $assertions;
    }
}
