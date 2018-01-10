<?php

namespace June\Framework\Steps;

trait IsNonExecutable
{
    public function isExecutable(): bool
    {
        return false;
    }
}
