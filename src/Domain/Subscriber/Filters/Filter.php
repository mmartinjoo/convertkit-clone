<?php

namespace Domain\Subscriber\Filters;

use Closure;
use Domain\Shared\DataTransferObjects\FilterData;
use Illuminate\Database\Eloquent\Builder;

abstract class Filter
{
    public function __construct(protected readonly FilterData $filterData)
    {
    }

    abstract public function handle(Builder $subscribers, Closure $next): Builder;
}
