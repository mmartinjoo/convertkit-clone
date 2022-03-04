<?php

namespace Domain\Automation\Actions;

use Domain\Automation\DataTransferObjects\AutomationData;
use Domain\Automation\DataTransferObjects\AutomationStepData;
use Domain\Automation\Enums\AutomationStepType;
use Domain\Automation\Models\Automation;
use Domain\Shared\Models\User;
use Illuminate\Support\Facades\DB;

class UpsertAutomationAction
{
    public static function execute(AutomationData $data, User $user): Automation
    {
        return DB::transaction(function () use ($data, $user) {
            $automation = Automation::updateOrcreate(
                [
                    'id' => $data->id,
                ],
                [
                    ...$data->toArray(),
                    'user_id' => $user->id,
                ],
            );

            $automation->steps->each->delete();

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

            $data->actions->toCollection()->each(fn (AutomationStepData $stepData) =>
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
