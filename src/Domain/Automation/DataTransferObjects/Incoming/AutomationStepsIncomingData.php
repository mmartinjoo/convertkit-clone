<?php

namespace Domain\Automation\DataTransferObjects\Incoming;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class AutomationStepsIncomingData extends Data
{
    public function __construct(
        public readonly AutomationStepIncomingData $event,
        /** @var DataCollection<AutomationStepIncomingData> */
        public readonly DataCollection $actions,
    ) {}
}
