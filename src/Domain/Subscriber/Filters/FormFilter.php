<?php

namespace Domain\Subscriber\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class FormFilter extends Filter
{
    public function handle(Builder $subscribers, Closure $next): Builder
    {
        $subscribers->orWhere(fn (Builder $subscribers) =>
            $subscribers->whereIn('form_id', $this->ids)
        );

        return $next($subscribers);
    }
}
