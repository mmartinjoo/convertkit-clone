<?php

namespace Domain\Automation\Actions\Steps;

use Domain\Automation\Models\AutomationStep;
use Domain\Subscriber\Models\Subscriber;

class AddToSequenceAction
{
    public function __invoke(Subscriber $subscriber, AutomationStep $step): void
    {
        $subscriber->sequences()->attach($step->value['id']);
    }
}
