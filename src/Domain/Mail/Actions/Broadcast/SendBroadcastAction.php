<?php

namespace Domain\Mail\Actions\Broadcast;

use Domain\Mail\Exceptions\Broadcast\CannotSendBroadcast;
use Domain\Mail\Mails\EchoMail;
use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

class SendBroadcastAction
{
    public static function execute(Broadcast $broadcast): int
    {
        if (!$broadcast->status->canSend()) {
            throw CannotSendBroadcast::because("Broadcast already sent at {$broadcast->sent_at}");
        }

        $subscribers = $broadcast->audience()
            ->each(fn (Subscriber $subscriber) =>
                Mail::to($subscriber)->queue(new EchoMail($broadcast))
            );

        $broadcast->markAsSent();

        return $subscribers->each(fn (Subscriber $subscriber) => $broadcast->sent_mails()->create([
            'subscriber_id' => $subscriber->id,
            'user_id' => $broadcast->user->id,
        ]))->count();
    }
}
