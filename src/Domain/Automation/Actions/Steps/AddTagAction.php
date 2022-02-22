<?php

namespace Domain\Automation\Actions\Steps;

use Domain\Automation\Models\AutomationStep;

class AddTagAction
{
    public function __invoke(Subscriber $subscriber, AutomationStep $step): void
    {
        $subscriber->tags()->attach($step->value['tag_id']);
    }
}
