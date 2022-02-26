<?php

namespace Domain\Automation\Events;

use Domain\Shared\Models\User;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscribedToFormEvent
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly Subscriber $subscriber,
        public readonly User $user,
    ) {}
}
