<?php

namespace Domain\Automation\DataTransferObjects\Incoming;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class AutomationIncomingData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly AutomationStepIncomingData $event,
        /** @var DataCollection<AutomationStepIncomingData> */
        public readonly DataCollection $actions,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::from([
            'name' => $request->name,
            'event' => $request->steps['event'],
            'actions' => $request->steps['actions'],
        ]);
    }
}
