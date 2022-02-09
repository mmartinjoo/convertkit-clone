<?php

namespace Domain\Mail\Actions\Broadcast;

use Domain\Mail\Enums\Broadcast\BroadcastStatus;
use Domain\Mail\Exceptions\Broadcast\CannotSendBroadcast;
use Domain\Shared\Mails\EchoMail;
use Domain\Mail\Models\Broadcast\Broadcast;
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
                Mail::to($subscriber)->queue(new EchoMail($broadcast))
            );

        $broadcast->status = BroadcastStatus::SENT;
        $broadcast->sent_at = now();
        $broadcast->save();

        return $subscribers->each(fn (Subscriber $subscriber) => $broadcast->sent_mails()->create([
            'subscriber_id' => $subscriber->id,
        ]))->count();
    }
}
