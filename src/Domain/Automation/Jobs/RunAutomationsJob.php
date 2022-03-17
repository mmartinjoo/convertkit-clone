<?php

namespace Domain\Automation\Jobs;

use Domain\Automation\Actions\RunAutomationsAction;
use Domain\Automation\Enums\Events;
use Domain\Shared\Models\User;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RunAutomationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly Subscriber $subscriber,
        private readonly User $user,
        private readonly Events $event,
    ) {}

    public function handle()
    {
        RunAutomationsAction::execute($this->subscriber, $this->user, $this->event);
    }
}
