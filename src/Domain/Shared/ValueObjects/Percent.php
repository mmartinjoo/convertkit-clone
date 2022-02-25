<?php

namespace Domain\Shared\ValueObjects;

class Percent
{
    public readonly float $value;
    public readonly string $formatted;

    public function __construct(float $value)
    {
        $this->value = $value;
        $this->formatted = number_format($this->value * 100, 1) . '%';
    }

    public static function from(float $numerator, float $denominator)
    {
        if ($denominator === 0.0) {
            return new self(0);
        }

        return new self($numerator / $denominator);
    }
}
