<?php

namespace Domain\Statistics\ValueObjects;

class Percent
{
    public readonly float $value;
    public readonly string $formatted;

    public function __construct(float $value)
    {
        $this->value = $value;
        $this->formatted = number_format($this->value * 100, 1) . '%';
    }

    public static function from(float $value): self
    {
        return new self($value);
    }
}
