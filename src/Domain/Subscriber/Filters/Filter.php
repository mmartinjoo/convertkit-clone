<?php

namespace Domain\Subscriber\Filters;

use Domain\Broadcast\DataTransferObjects\BroadcastFilterData;
use Illuminate\Database\Eloquent\Builder;

abstract class Filter
{
    public function __construct(protected readonly BroadcastFilterData $filterData)
    {
    }

    abstract public function execute(Builder $subscribers): Builder;
}
