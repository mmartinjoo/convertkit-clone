<?php

namespace Domain\Automation\DataTransferObjects;

use Domain\Automation\Enums\AutomationStepType;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;

class AutomationStepData extends Data
{
    public function __construct(
        public readonly string $name,
        #[WithCast(EnumCast::class)]
        public readonly AutomationStepType $type,
        public readonly AutomationData $automation,
        public readonly array $value,
    ) {}
}
