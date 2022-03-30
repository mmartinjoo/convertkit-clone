<?php

namespace Domain\Mail\Actions\Sequence;

use Arr;
use Domain\Mail\Enums\Sequence\SubscriberStatus;
use Domain\Mail\Mails\EchoMail;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Mail\Models\Sequence\SequenceSubscriber;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class ProceedSequenceAction
{
    /**
     * @var array<int, array<int>>
     */
    private static array $mailsBySubscribers = [];

    public static function execute(Sequence $sequence): void
    {
        self::$mailsBySubscribers = [];

        foreach ($sequence->mails()->wherePublished()->get() as $mail) {
            [$audience, $schedulableAudience] = self::audience($mail);

            self::sendMails($schedulableAudience, $mail, $sequence);

            self::addMailToAudience($audience, $mail);

            self::markAsInProgress($sequence, $schedulableAudience);
        }

        self::markAsCompleted($sequence);
    }

    /**
     * @return array<Collection<Subscriber>>
     */
    private static function audience(SequenceMail $mail): array
    {
        $audience = $mail->audience();

        if (!$mail->shouldSendToday()) {
            return [$audience, collect([])];
        }

        $schedulableAudience = $audience
            ->reject->alreadyReceived($mail)
            ->reject->tooEarlyFor($mail);

        return [$audience, $schedulableAudience];
    }

    private static function sendMails(Collection $schedulableAudience, SequenceMail $mail, Sequence $sequence): void
    {
        foreach ($schedulableAudience as $subscriber) {
            Mail::to($subscriber)->queue(new EchoMail($mail));

            $mail->sent_mails()->create([
                'subscriber_id' => $subscriber->id,
                'user_id' => $sequence->user->id,
            ]);
        }
    }

    /**
     * @param Sequence $sequence
     * @param Collection<Subscriber> $schedulableAudience
     */
    private static function markAsInProgress(Sequence $sequence, Collection $schedulableAudience): void
    {
        SequenceSubscriber::query()
            ->whereBelongsTo($sequence)
            ->whereIn('subscriber_id', $schedulableAudience->pluck('id'))
            ->update([
                'status' => SubscriberStatus::InProgress,
            ]);
    }

    public static function markAsCompleted(Sequence $sequence): void
    {
        $subscribers = Subscriber::withCount([
            'received_mails' => fn (Builder $receivedMails) => $receivedMails->whereSequence($sequence)
        ])
        ->find(array_keys(self::$mailsBySubscribers))
        ->mapWithKeys(fn (Subscriber $subscriber) => [
            $subscriber->id => $subscriber,
        ]);

        $completedSubscriberIds = [];
        foreach (self::$mailsBySubscribers as $subscriberId => $mailIds) {
            $subscriber = $subscribers[$subscriberId];

            if ($subscriber->received_mails_count === count($mailIds)) {
                $completedSubscriberIds[] = $subscriber->id;
            }
        }

        SequenceSubscriber::query()
            ->whereBelongsTo($sequence)
            ->whereIn('subscriber_id', $completedSubscriberIds)
            ->update([
                'status' => SubscriberStatus::Completed,
            ]);
    }

    /**
     * @param Collection<Subscriber> $audience
     */
    private static function addMailToAudience(Collection $audience, SequenceMail $mail): void
    {
        foreach ($audience as $subscriber) {
            if (!Arr::get(self::$mailsBySubscribers, $subscriber->id)) {
                self::$mailsBySubscribers[$subscriber->id] = [];
            }

            self::$mailsBySubscribers[$subscriber->id][] = $mail->id;
        }
    }
}
