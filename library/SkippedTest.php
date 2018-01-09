<?php

namespace June\Framework;

class SkippedTest extends Test
{
    public function canExecute(): bool
    {
        return false;
    }
}
