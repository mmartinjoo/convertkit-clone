<?php

namespace Domain\Subscriber\Actions;

use Domain\Broadcast\DataTransferObjects\BroadcastFilterData;
use Domain\Broadcast\Models\Broadcast;
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
    public static function execute(Broadcast $broadcast): Collection
    {
        return app(Pipeline::class)
            ->send(Subscriber::query())
            ->through(self::filters($broadcast))
            ->thenReturn()
            ->get();
    }

    /**
     * @return array<Filter>
     */
    private static function filters(Broadcast $broadcast): array
    {
        return $broadcast->filters->map(fn (BroadcastFilterData $filterData) =>
            match ($filterData->type) {
                'tag' => new TagFilter($filterData),
                'form' => new FormFilter($filterData),
                default => InvalidFilterException::because("Filter not found for type {$filterData->type}"),
            }
        )->toArray();
    }
}
