<?php

namespace Domain\Subscriber\Actions;

use DB;
use Domain\Subscriber\Models\Subscriber;

class DeleteSubscriberAction
{
    public static function execute(Subscriber $subscriber): void
    {
        DB::transaction(function () use ($subscriber) {
            $subscriber->sequences()->detach();

            $subscriber->delete();
        });
    }
}
