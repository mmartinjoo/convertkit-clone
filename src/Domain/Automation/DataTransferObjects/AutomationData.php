<?php

namespace Domain\Automation\DataTransferObjects;

use Domain\Automation\Enums\AutomationStepType;
use Domain\Automation\Models\Automation;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class AutomationData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly AutomationStepData $event,
        /** @var DataCollection<AutomationStepData> */
        public readonly DataCollection $actions,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::from([
            'id' => $request->id,
            'name' => $request->name,
            'event' => $request->steps['event'],
            'actions' => $request->steps['actions'],
        ]);
    }

    public static function fromModel(Automation $automation): self
    {
        return self::from([
            'id' => $automation->id,
            'name' => $automation->name,
            'event' => $automation->steps()->whereType(AutomationStepType::Event)->first(),
            'actions' => $automation->steps()->whereType(AutomationStepType::Action)->get()->all(),
        ]);
    }
}
