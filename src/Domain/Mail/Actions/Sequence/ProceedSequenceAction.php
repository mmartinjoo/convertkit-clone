<?php

namespace Domain\Mail\Actions\Sequence;

use Arr;
use Domain\Mail\Enums\Sequence\SubscriberStatus;
use Domain\Mail\Mails\EchoMail;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Mail\Models\Sequence\SequenceSubscriber;
use Domain\Subscriber\Models\Subscriber;
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
        foreach ($sequence->mails()->wherePublished()->get() as $mail) {
            $audience = $mail->audience();
            $schedulableAudience = self::schedulableAudience($audience, $mail);

            foreach ($schedulableAudience as $subscriber) {
                Mail::to($subscriber)->queue(new EchoMail($mail));

                $mail->sent_mails()->create([
                    'subscriber_id' => $subscriber->id,
                    'user_id' => $sequence->user->id,
                ]);
            }

            self::addMailToAudience($audience, $mail);

            self::markAsInProgress($sequence, $schedulableAudience);
        }

        self::markAsCompleted($sequence);
    }

    /**
     * @param Collection<Subscriber> $audience
     * @param SequenceMail $mail
     * @return Collection<Subscriber>
     */
    private static function schedulableAudience(Collection $audience, SequenceMail $mail): Collection
    {
        if (!$mail->shouldSendToday()) {
            return collect([]);
        }

        return $audience
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

    public static function markAsCompleted(Sequence $sequence): void
    {
        $subscribers = Subscriber::withCount('received_mails')
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
