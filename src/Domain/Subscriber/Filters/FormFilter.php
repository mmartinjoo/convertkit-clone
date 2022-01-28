<?php

namespace Domain\Subscriber\Filters;

use Illuminate\Database\Eloquent\Builder;

class FormFilter extends Filter
{
    public function execute(Builder $subscribers): Builder
    {
        return $subscribers->whereIn('form_id', $this->filterData->value);
    }
}
