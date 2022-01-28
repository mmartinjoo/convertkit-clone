<?php

namespace Domain\Subscriber\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class TagFilter extends Filter
{
    public function handle(Builder $subscribers, Closure $next): Builder
    {
        $subscribers->orWhere(fn (Builder $subscribers) =>
            $subscribers->whereTagsExactly($this->filterData->value)
        );

        return $next($subscribers);
    }
}
