<?php

namespace Domain\Subscriber\Actions;

use Domain\Subscriber\Models\Subscriber;

class DeleteSubscriberAction
{
    public static function execute(Subscriber $subscriber): void
    {
        $subscriber->delete();
    }
}
