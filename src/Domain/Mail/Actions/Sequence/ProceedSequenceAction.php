<?php

namespace Domain\Mail\Actions\Sequence;

use Domain\Mail\Mails\EchoMail;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Subscriber\Actions\FilterSubscribersAction;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class ProceedSequenceAction
{
    public static function execute(Sequence $sequence): int
    {
        $sentMailCount = 0;
        foreach ($sequence->mails()->wherePublished()->get() as $mail) {
            $subscribers = self::subscribers($mail);

            foreach ($subscribers as $subscriber) {
                Mail::to($subscriber)->queue(new EchoMail($mail));

                $mail->sent_mails()->create([
                    'subscriber_id' => $subscriber->id,
                ]);
            }

            self::markAsInProgress($sequence, $subscribers);

            $sentMailCount += $subscribers->count();
        }

        self::markAsCompleted($sequence);

        return $sentMailCount;
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

    /**
     * @param Sequence $sequence
     * @param Collection<Subscriber> $subscribers
     */
    private static function markAsInProgress(Sequence $sequence, Collection $subscribers): void
    {
        $sequence
            ->subscribers()
            ->whereIn('subscriber_id', $subscribers->pluck('id'))
            ->update([
                'status' => 'in-progress',
            ]);
    }

    public static function markAsCompleted(Sequence $sequence)
    {
        $mailWithLargestDelay = $sequence->load('mails.schedule')->mails->sortByDesc(function (SequenceMail $mail) {
            return $mail->schedule->delayInHours();
        })->first();

        foreach ($sequence->subscribers as $subscriber) {
            $lastMail = $subscriber
                ->sent_mails()
                ->whereSequence($sequence)
                ->orderByDesc('sent_at')
                ->first();

            if (!$lastMail) {
                continue;
            }

            $sinceLastMail = now()->diffInHours($lastMail->sent_at);
            if ($sinceLastMail > $mailWithLargestDelay->schedule->delayInHours()) {
                $sequence
                    ->subscribers()
                    ->updateExistingPivot($subscriber->id, ['status' => 'completed']);
            }
        }
    }
}
