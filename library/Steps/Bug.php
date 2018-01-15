<?php

namespace June\Framework\Steps;

use June\Framework\Contracts\Step as StepContract;

class Bug implements StepContract
{
    use Step, IsExecutable;
}
