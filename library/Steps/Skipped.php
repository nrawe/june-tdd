<?php

namespace June\Framework\Steps;

use June\Framework\Contracts\Step as StepContract;

class Skipped implements StepContract
{
    use Step, IsNonExecutable;
}
