<?php

namespace Domain\Broadcast\Actions;

use Domain\Broadcast\Mail\BroadcastMail;
use Domain\Broadcast\Models\Broadcast;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

class SendBroadcastAction
{
    public static function execute(Broadcast $broadcast): void
    {
        $broadcast->subscribers->each(fn (Subscriber $subscriber) =>
            Mail::to($subscriber)->queue(new BroadcastMail($broadcast))
        );
    }
}
