<?php

namespace Domain\Sequence\Actions;

use Domain\Broadcast\Mail\BroadcastMail;
use Domain\Sequence\Models\Sequence;
use Domain\Sequence\Models\SequenceMail;
use Domain\Subscriber\Actions\FilterSubscribersAction;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class ProceedSequenceAction
{
    public static function execute(Sequence $sequence): void
    {
        $sequence->mails->each(function (SequenceMail $mail) {
            self::subscribers($mail)
                ->each(fn (Subscriber $subscriber) =>
                    Mail::to($subscriber)->queue(new BroadcastMail($mail))
                );
        });
    }

    private static function subscribers(SequenceMail $mail): Collection
    {
        if (!collect($mail->schedule->days)->contains(now()->dayOfWeek)) {
            return collect([]);
        }

        return FilterSubscribersAction::execute($mail)
            ->filter(fn (Subscriber $subscirber) =>
                $subscirber->received_mails()->where('mailable_id', '!=', $mail->id)
            )
            ->filter(fn (Subscriber $subscirber) =>
                $mail->schedule->timePassed($subscirber->last_received_mail->sent_at) < $mail->schedule->delay
            );
    }
}
