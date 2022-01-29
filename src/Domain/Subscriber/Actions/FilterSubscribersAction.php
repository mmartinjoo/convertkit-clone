<?php

namespace Domain\Subscriber\Actions;

use Domain\Shared\DataTransferObjects\FilterData;
use Domain\Shared\Models\Concerns\HasSubscriberFilters;
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
    public static function execute(HasSubscriberFilters $mail): Collection
    {
        return app(Pipeline::class)
            ->send(Subscriber::query())
            ->through(self::filters($mail))
            ->thenReturn()
            ->get();
    }

    /**
     * @return array<Filter>
     */
    private static function filters(HasSubscriberFilters $mail): array
    {
        return $mail->filters()->map(fn (FilterData $filterData) =>
            match ($filterData->type) {
                'tag' => new TagFilter($filterData),
                'form' => new FormFilter($filterData),
                default => InvalidFilterException::because("Filter not found for type {$filterData->type}"),
            }
        )->toArray();
    }
}
