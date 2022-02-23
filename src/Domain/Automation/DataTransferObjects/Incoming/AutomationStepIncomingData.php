<?php

namespace Domain\Automation\DataTransferObjects\Incoming;

use Domain\Automation\Models\AutomationStep;
use Spatie\LaravelData\Data;

class AutomationStepIncomingData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly int $value,
    ) {}

    public static function fromModel(AutomationStep $step): self
    {
        return self::from([
            'id' => $step->id,
            'name' => $step->name,
            'value' => $step->value['id'],
        ]);
    }
}
