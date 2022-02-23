<?php

namespace Domain\Automation\DataTransferObjects;

use Domain\Automation\Models\Automation;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

class AutomationData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        /** @var DataCollection<AutomationStepData> */
        public readonly Lazy|DataCollection $steps,
    ) {}

    public static function fromModel(Automation $automation): self
    {
        return self::from([
            ...$automation->toArray(),
            'steps' => Lazy::whenLoaded('steps', $automation, fn () => AutomationStepData::collection($automation->steps)),
        ]);
    }
}
