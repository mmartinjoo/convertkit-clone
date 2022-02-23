<?php

namespace Domain\Automation\Actions;

use Domain\Automation\DataTransferObjects\Incoming\AutomationIncomingData;
use Domain\Automation\DataTransferObjects\Incoming\AutomationStepIncomingData;
use Domain\Automation\Enums\AutomationStepType;
use Domain\Automation\Models\Automation;
use Illuminate\Support\Facades\DB;

class CreateAutomationAction
{
    public static function execute(AutomationIncomingData $data): Automation
    {
        return DB::transaction(function () use ($data) {
            $automation = Automation::create([
                'name' => $data->name,
            ]);

            $automation->steps()->create([
                'type' => AutomationStepType::Event,
                'name' => $data->steps->event->name,
                'value' => ['id' => $data->steps->event->value],
            ]);

            $data->steps->actions->toCollection()->each(fn (AutomationStepIncomingData $stepData) =>
                $automation->steps()->create([
                    'type' => AutomationStepType::Action,
                    'name' => $stepData->name,
                    'value' => ['id' => $stepData->value],
                ])
            );

            return $automation->load('steps');
        });
    }
}
