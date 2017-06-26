<?php

namespace June\Framework\Assertions;

interface Contract
{
    public function message(): string;

    public function name(): string;

    public function passes($a, $b): bool;
}
