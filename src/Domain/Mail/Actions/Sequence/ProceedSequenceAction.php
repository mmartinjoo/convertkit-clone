<?php

namespace Domain\Mail\Actions\Sequence;

use Arr;
use Domain\Mail\Enums\Sequence\SubscriberStatus;
use Domain\Mail\Mails\EchoMail;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class ProceedSequenceAction
{
    public static function execute(Sequence $sequence): int
    {
        $sentMailCount = 0;
        $mailsBySubscribers = [];

        foreach ($sequence->mails()->wherePublished()->get() as $mail) {
            // Azért nem jó, mert a tooEarly stb miatt a második e-mail audience nem tartalmazza az első palit
            $potentialSubscribers = $mail->audience();
            $subscribers = self::subscribers($mail, $potentialSubscribers);

            foreach ($subscribers as $subscriber) {
                Mail::to($subscriber)->queue(new EchoMail($mail));

                $mail->sent_mails()->create([
                    'subscriber_id' => $subscriber->id,
                    'user_id' => $sequence->user->id,
                ]);
            }

            foreach ($potentialSubscribers as $subscriber) {
                if (!Arr::get($mailsBySubscribers, $subscriber->id)) {
                    $mailsBySubscribers[$subscriber->id] = [];
                }

                $mailsBySubscribers[$subscriber->id][] = $mail->id;
            }

            self::markAsInProgress($sequence, $subscribers);

            $sentMailCount += $subscribers->count();
        }

        self::markAsCompleted($mailsBySubscribers, $sequence);

//        self::markAsCompleted($sequence);

        return $sentMailCount;
    }

    private static function subscribers(SequenceMail $mail, Collection $potentialSubscribers): Collection
    {
        if (!$mail->shouldSendToday()) {
            return collect([]);
        }

        return $potentialSubscribers
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
                'status' => SubscriberStatus::InProgress,
            ]);
    }

    public static function markAsCompleted(array $mailsBySubscribers, Sequence $sequence): void
    {
        // 1 query per sub
        $subscribers = Subscriber::with('received_mails')->find(array_keys($mailsBySubscribers));
        foreach ($mailsBySubscribers as $subscriberId => $mailIds) {
            $subscriber = $subscribers->where('id', $subscriberId)->first();

            if ($subscriber->received_mails->count() === count($mailIds)) {
                $sequence
                    ->subscribers()
                    ->updateExistingPivot($subscriber->id, ['status' => SubscriberStatus::Completed]);
            }
        }
    }

    // mail * (1) + (per sequence subscriber * 2)
    // 8 mail, 50000 subs = 100008 query
    public static function markAsCompletedOld(Sequence $sequence)
    {
        // query
        $mailWithLargestDelay = $sequence->load('mails.schedule')->mails->sortByDesc(function (SequenceMail $mail) {
            return $mail->schedule->delayInHours();
        })->first();

        // can be eager loaded
        foreach ($sequence->subscribers as $subscriber) {
            // query
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
                    ->updateExistingPivot($subscriber->id, ['status' => SubscriberStatus::Completed]);
            }
        }
    }
}
