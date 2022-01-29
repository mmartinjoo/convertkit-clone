<?php

namespace Domain\Broadcast\Actions;

use Domain\Broadcast\Enums\BroadcastStatus;
use Domain\Broadcast\Exceptions\CannotSendBroadcast;
use Domain\Broadcast\Mail\BroadcastMail;
use Domain\Broadcast\Models\Broadcast;
use Domain\Subscriber\Actions\FilterSubscribersAction;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

class SendBroadcastAction
{
    public static function execute(Broadcast $broadcast): int
    {
        if ($broadcast->status === BroadcastStatus::SENT) {
            throw new CannotSendBroadcast("Broadcast already sent at {$broadcast->sent_at}");
        }

        $subscribers = FilterSubscribersAction::execute($broadcast)
            ->each(fn (Subscriber $subscriber) =>
                Mail::to($subscriber)->queue(new BroadcastMail($broadcast))
            );

        $broadcast->status = BroadcastStatus::SENT;
        $broadcast->sent_at = now();
        $broadcast->save();

        return $subscribers
            ->each(fn (Subscriber $subscriber) =>
                $broadcast->subscribers()->attach($subscriber->id)
            )
            ->count();
    }
}
