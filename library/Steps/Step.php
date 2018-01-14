<?php

namespace June\Framework\Steps;

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

    public function __construct(string $name, callable $body)
    {
        $this->body = $body;
        $this->name = $name;
    }

    public function __debugInfo(): array
    {
        return [
            'name' => $this->name,
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
}
