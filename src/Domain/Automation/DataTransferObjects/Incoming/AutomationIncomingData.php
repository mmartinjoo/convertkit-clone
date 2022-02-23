<?php

namespace Domain\Automation\DataTransferObjects\Incoming;

use Spatie\LaravelData\Data;

class AutomationIncomingData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly AutomationStepsIncomingData $steps,
    ) {}
}
