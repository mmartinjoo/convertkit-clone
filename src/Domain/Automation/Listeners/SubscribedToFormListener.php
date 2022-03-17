<?php

namespace Domain\Automation\Listeners;

use Domain\Automation\Enums\Events;
use Domain\Automation\Events\SubscribedToFormEvent;
use Domain\Automation\Jobs\RunAutomationsJob;

class SubscribedToFormListener
{
    public function handle(SubscribedToFormEvent $event)
    {
        RunAutomationsJob::dispatch(
            $event->subscriber,
            $event->user,
            Events::SubscribedToForm,
        );
    }
}
