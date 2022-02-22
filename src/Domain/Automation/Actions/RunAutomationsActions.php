<?php

namespace Domain\Automation\Actions;

use Domain\Automation\Enums\Actions;
use Domain\Automation\Enums\AutomationStepType;
use Domain\Automation\Models\Automation;
use Domain\Subscriber\Models\Subscriber;

class RunAutomationsActions
{
    public static function execute(Subscriber $subscriber)
    {
        $automations = Automation::with('steps')->get();
        foreach ($automations as $automation) {
            $steps = $automation->steps()->whereType(AutomationStepType::Action)->get();

            foreach ($steps as $step) {
                $actionClass = collect(Actions::cases())->firstWhere('name', $step->name)->value;
                $action = app($actionClass);
                $action($subscriber, $step);
            }
        }
    }
}
