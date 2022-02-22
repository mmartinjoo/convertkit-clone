<?php

namespace Domain\Subscriber\Actions;

use Domain\Mail\Contracts\Sendable;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Subscriber\Exceptions\InvalidFilterException;
use Domain\Subscriber\Filters\{Filter, FormFilter, TagFilter};
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
            $subscribers = $mail->sequence->subscribers();
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
            ->map(fn (array $ids, string $key) =>
                match ($key) {
                    'tag_ids' => new TagFilter($ids),
                    'form_ids' => new FormFilter($ids),
                    default => InvalidFilterException::because("Filter not found for type {$key}"),
                }
            )
            ->values()
            ->all();
    }
}
