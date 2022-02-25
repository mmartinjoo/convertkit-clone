<?php

namespace Domain\Automation\Listeners;

use Domain\Automation\Actions\RunAutomationsAction;
use Domain\Automation\Events\SubscribedToFormEvent;

class SubscribedToFormListener
{
    public function handle(SubscribedToFormEvent $event)
    {
        RunAutomationsAction::execute($event->subscriber);
    }
}
