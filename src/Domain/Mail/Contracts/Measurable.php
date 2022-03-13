<?php

namespace Domain\Mail\Contracts;

use Domain\Mail\DataTransferObjects\PerformanceData;
use Illuminate\Contracts\Database\Query\Builder;

interface Measurable
{
    public function performance(): PerformanceData;
    public function sentMailsQuery(): Builder;
}
