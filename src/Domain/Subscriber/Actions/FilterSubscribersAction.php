<?php

namespace Domain\Subscriber\Actions;

use Domain\Broadcast\DataTransferObjects\BroadcastFilterData;
use Domain\Broadcast\Models\Broadcast;
use Domain\Subscriber\Exceptions\InvalidFilterException;
use Domain\Subscriber\Filters\Filter;
use Domain\Subscriber\Filters\FormFilter;
use Domain\Subscriber\Filters\TagFilter;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Support\Collection;

class FilterSubscribersAction
{
    /**
     * @return Collection<Subscriber>
     */
    public static function execute(Broadcast $broadcast): Collection
    {
        $filters = self::createFilters($broadcast);
        $subscriberQuery = $broadcast->subscribers()->getQuery();

        foreach ($filters as $filter) {
            $subscriberQuery = $filter->execute($subscriberQuery);
        }

        return $subscriberQuery->get();
    }

    /**
     * @return Collection<Filter>
     */
    private static function createFilters(Broadcast $broadcast): Collection
    {
        return $broadcast->filters->map(fn (BroadcastFilterData $filterData) =>
            match ($filterData->type) {
                'tag' => new TagFilter($filterData),
                'form' => new FormFilter($filterData),
                default => InvalidFilterException::because("Filter not found for type {$filterData->type}"),
            }
        );
    }
}
