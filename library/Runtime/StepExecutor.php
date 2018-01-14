<?php

namespace June\Framework\Runtime;

use June\Framework\Unit;
use June\Framework\Contracts\Step;
use June\Framework\Factories\AssertionFactory;
use June\Framework\Exceptions\BadUserException;
use June\Framework\Assertions\AssertionException;
use ReflectionFunction;

class StepExecutor
{
    protected $assertions;

    protected $feedback;

    public function __construct(AssertionFactory $assertions, Feedback $feedback)
    {
        $this->assertions = $assertions;
        $this->feedback = $feedback;
    }

    public function execute(Step $step): bool
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

    protected function attempt(Step $step): bool
    {
        if (! $step->isExecutable()) {
            return true;
        }

        return $this->attemptBody($step->body());
    }

    protected function attemptBody(callable $body): bool
    {
        $assertions = $this->findAssertionsForBody($body);

        $body(...$assertions);

        return true;
    }

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
