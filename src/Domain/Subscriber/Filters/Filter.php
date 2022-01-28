<?php

namespace Domain\Subscriber\Filters;

use Closure;
use Domain\Broadcast\DataTransferObjects\BroadcastFilterData;
use Illuminate\Database\Eloquent\Builder;

abstract class Filter
{
    public function __construct(protected readonly BroadcastFilterData $filterData)
    {
    }

    abstract public function handle(Builder $subscribers, Closure $next): Builder;
}
