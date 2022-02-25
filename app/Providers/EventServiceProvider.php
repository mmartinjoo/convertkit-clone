<?php

namespace App\Providers;

use Domain\Automation\Events\SubscribedToFormEvent;
use Domain\Automation\Listeners\SubscribedToFormListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SubscribedToFormEvent::class => [
            SubscribedToFormListener::class,
        ],
    ];

    public function boot()
    {
        //
    }
}
