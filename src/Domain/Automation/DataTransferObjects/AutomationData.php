<?php

namespace Domain\Automation\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class AutomationData extends Data
{
    public function __construct(
        public readonly string $name,
        /** @var DataCollection<AutomationStepData> */
        public readonly DataCollection $steps,
    ) {}
}
