<?php

namespace June\Framework\Cases;

class Skipped extends AbstractCase
{
    public function execute(): bool
    {
        return false;
    }
}
