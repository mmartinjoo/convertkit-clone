<?php

namespace Domain\Automation\DataTransferObjects\Incoming;

use Spatie\LaravelData\Data;

class AutomationStepIncomingData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly int $value,
    ) {}
}
