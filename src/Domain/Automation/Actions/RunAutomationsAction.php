<?php

namespace Domain\Automation\Actions;

use Domain\Automation\Enums\Actions;
use Domain\Automation\Enums\AutomationStepType;
use Domain\Automation\Models\Automation;
use Domain\Subscriber\Models\Subscriber;

class RunAutomationsAction
{
    public static function execute(Subscriber $subscriber)
    {
        $automations = Automation::with('steps')
            ->whereHas('steps', function ($steps) use ($subscriber) {
                $steps
                    ->whereType(AutomationStepType::Event)
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
