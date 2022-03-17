<?php

namespace Domain\Automation\Actions;

use Domain\Automation\Enums\Actions;
use Domain\Automation\Enums\AutomationStepType;
use Domain\Automation\Enums\Events;
use Domain\Automation\Models\Automation;
use Domain\Shared\Models\User;
use Domain\Subscriber\Models\Subscriber;

class RunAutomationsAction
{
    public static function execute(Subscriber $subscriber, User $user, Events $event)
    {
        $automations = Automation::with('steps')
            ->whereBelongsTo($user)
            ->whereHas('steps', function ($steps) use ($subscriber, $event) {
                $steps
                    ->whereType(AutomationStepType::Event)
                    ->whereName($event)
                    ->where('value->id', $subscriber->form_id);
            })
            ->get();

        foreach ($automations as $automation) {
            $steps = $automation->steps()->whereType(AutomationStepType::Action)->get();

            foreach ($steps as $step) {
                $action = Actions::from($step->name)->createAction();
                $action($subscriber, $step);
            }
        }
    }
}
