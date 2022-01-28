<?php

namespace Domain\Subscriber\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class TagFilter extends Filter
{
    public function handle(Builder $subscribers, Closure $next): Builder
    {
        $subscribers->orWhere(fn (Builder $subscribers) =>
            $subscribers->whereHas('tags', fn (Builder $tags) =>
                $tags->whereIn('id', $this->filterData->value)
            )->whereDoesntHave('tags', fn (Builder $tags) =>
                $tags->whereNotIn('id', $this->filterData->value)
            )
        );

        return $next($subscribers);
    }
}
