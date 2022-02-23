<?php

namespace Domain\Automation\Actions;

use Domain\Automation\DataTransferObjects\Incoming\AutomationIncomingData;
use Domain\Automation\DataTransferObjects\Incoming\AutomationStepIncomingData;
use Domain\Automation\Enums\AutomationStepType;
use Domain\Automation\Models\Automation;
use Illuminate\Support\Facades\DB;

class UpsertAutomationAction
{
    public static function execute(AutomationIncomingData $data): Automation
    {
        return DB::transaction(function () use ($data) {
            $automation = Automation::updateOrcreate(
                [
                    'id' => $data->id,
                ],
                $data->toArray(),
            );

            $automation->steps()->updateOrCreate(
                [
                    'id' => $data->event->id,
                ],
                [
                    'type' => AutomationStepType::Event,
                    'name' => $data->event->name,
                    'value' => ['id' => $data->event->value],
                ]
            );

            $data->actions->toCollection()->each(fn (AutomationStepIncomingData $stepData) =>
                $automation->steps()->updateOrcreate(
                    [
                        'id' => $stepData->id,
                    ],
                    [
                        'type' => AutomationStepType::Action,
                        'name' => $stepData->name,
                        'value' => ['id' => $stepData->value],
                    ]
                )
            );

            return $automation->load('steps');
        });
    }
}
