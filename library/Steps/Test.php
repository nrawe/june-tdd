<?php

namespace June\Framework\Steps;

use June\Framework\Contracts\Step as StepContract;

class Test implements StepContract
{
    use Step, IsExecutable;
}
