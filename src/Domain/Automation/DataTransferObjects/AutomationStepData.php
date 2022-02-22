<?php

namespace Domain\Automation\DataTransferObjects;

use Domain\Automation\Enums\AutomationStepType;
use Domain\Automation\Models\AutomationStep;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class AutomationStepData extends Data
{
    public function __construct(
        public readonly string $name,
        #[WithCast(EnumCast::class)]
        public readonly AutomationStepType $type,
        public readonly Lazy|AutomationData $automation,
        public readonly array $value,
    ) {}

    public static function fromModel(AutomationStep $step): self
    {
        return self::from([
            ...$step->toArray(),
            'automation' => Lazy::whenLoaded('automation', $step, fn () => AutomationData::from($step->automation)),
        ]);
    }
}
