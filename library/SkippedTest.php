<?php

namespace June\Framework;

class SkippedTest extends Test
{
    public function execute(): bool
    {
        return false;
    }
}
