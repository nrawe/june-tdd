<?php

namespace June\Framework\Assertions;

class Equal implements Contract
{
    public function message(): string
    {
        return '%a !== %b';
    }

    public function name(): string
    {
        return 'equal';
    }

    public function passes($a, $b): bool
    {
        return $a === $b;
    }
}
