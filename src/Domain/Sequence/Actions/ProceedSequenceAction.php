<?php

namespace Domain\Sequence\Actions;

use Domain\Shared\Mails\EchoMail;
use Domain\Sequence\Models\Sequence;
use Domain\Sequence\Models\SequenceMail;
use Domain\Subscriber\Actions\FilterSubscribersAction;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class ProceedSequenceAction
{
    public static function execute(Sequence $sequence): int
    {
        return $sequence->mails->reduce(function (int $count, SequenceMail $mail) {
            $sentMailsCount = self::subscribers($mail)
                ->each(fn (Subscriber $subscriber) =>
                    Mail::to($subscriber)->queue(new EchoMail($mail))
                )
                ->each(fn (Subscriber $subscriber) => $mail->sent_mails()->create([
                    'subscriber_id' => $subscriber->id,
                ]))
                ->count();

            return $count + $sentMailsCount;
        }, 0);
    }

    private static function subscribers(SequenceMail $mail): Collection
    {
        if (!$mail->shouldSendToday()) {
            return collect([]);
        }

        return FilterSubscribersAction::execute($mail)
            ->reject->alreadyReceived($mail)
            ->reject->tooEarlyFor($mail);
    }
}
