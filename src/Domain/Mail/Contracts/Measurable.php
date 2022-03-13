<?php

namespace Domain\Mail\Contracts;

use Illuminate\Contracts\Database\Query\Builder;

interface Measurable
{
    public function totalInstances(): int;
    public function sentMailsQuery(): Builder;
}
