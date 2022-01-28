<?php

namespace Domain\Subscriber\Filters;

use Illuminate\Database\Eloquent\Builder;

class TagFilter extends Filter
{
    public function execute(Builder $subscribers): Builder
    {
        return $subscribers->whereHas('tags', fn (Builder $tags) =>
            $tags->whereIn('id', $this->filterData->value)
        )->whereDoesntHave('tags', fn (Builder $tags) =>
            $tags->whereNotIn('id', $this->filterData->value)
        );
    }
}
