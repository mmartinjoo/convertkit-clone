<?php

namespace Domain\Broadcast\Actions;

use Domain\Broadcast\Mail\BroadcastMail;
use Domain\Broadcast\Models\Broadcast;
use Domain\Subscriber\Actions\FilterSubscribersAction;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

class SendBroadcastAction
{
    public static function execute(Broadcast $broadcast): int
    {
        $subscribers = FilterSubscribersAction::execute($broadcast)
            ->each(fn (Subscriber $subscriber) =>
                Mail::to($subscriber)->queue(new BroadcastMail($broadcast))
            );

        return $subscribers
            ->each(fn (Subscriber $subscriber) => $broadcast->subscribers()->attach($subscriber->id))
            ->count();
    }
}
