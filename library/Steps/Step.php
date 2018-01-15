<?php

namespace June\Framework\Steps;

use June\Framework\Contracts\Unit;

trait Step
{
    /**
     * The body of the step to be executed.
     * 
     * @var callable
     */
    protected $body;

    /**
     * The name of the step to be executed.
     * 
     * @var string
     */
    protected $name;

    /**
     * The Unit instance that the Step belongs to.
     * 
     * @var Unit|null
     */
    protected $unit;

    public function __construct(string $name, callable $body)
    {
        $this->body = $body;
        $this->name = $name;
    }

    public function __debugInfo(): array
    {
        return [
            'name' => $this->name,
            'unit' => $this->unit,
        ];
    }

    public function body(): callable
    {
        return $this->body;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function unit(?Unit $unit): ?Unit
    {
        if ($unit) {
            $this->unit = $unit;
        }

        return $this->unit;
    }
}
