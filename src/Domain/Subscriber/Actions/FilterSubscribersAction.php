<?php

namespace Domain\Subscriber\Actions;

use Domain\Mail\Contracts\Sendable;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Subscriber\Enums\Filters;
use Domain\Subscriber\Filters\Filter;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;

class FilterSubscribersAction
{
    /**
     * @return Collection<Subscriber>
     */
    public static function execute(Sendable $mail): Collection
    {
        $subscribers = Subscriber::query();
        if ($mail instanceof SequenceMail) {
            $subscribers = Subscriber::whereIn('id', $mail->sequence->subscribers()->select('subscribers.id')->pluck('id'));
        }

        return app(Pipeline::class)
            ->send($subscribers)
            ->through(self::filters($mail))
            ->thenReturn()
            ->get();
    }

    /**
     * @return array<Filter>
     */
    public static function filters(Sendable $mail): array
    {
        return collect($mail->filters()->all())
            ->reject(fn (array $ids) => count($ids) === 0)
            ->map(fn (array $ids, string $key) => Filters::from($key)->createFilter($ids))
            ->values()
            ->all();
    }
}
