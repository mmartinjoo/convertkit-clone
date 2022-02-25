<?php

namespace Domain\Automation\Actions;

use Domain\Automation\Models\Automation;

class DeleteAutomationAction
{
    public static function execute(Automation $automation): void
    {
        $automation->delete();
    }
}
