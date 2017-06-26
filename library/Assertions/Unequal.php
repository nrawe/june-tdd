<?php

namespace June\Framework\Assertions;

class Unequal implements Contract
{
    public function message(): string
    {
        return '%a === %b';
    }

    public function name(): string
    {
        return 'unequal';
    }

    public function passes($a, $b): bool
    {
        return $a !== $b;
    }
}
