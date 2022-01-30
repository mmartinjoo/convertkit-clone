<?php

namespace Domain\Statistics\DataTransferObjects;

use Spatie\LaravelData\Data;

class NewSubscribersCountData extends Data
{
    public function __construct(
        public readonly int $total,
        public readonly int $thisWeek,
        public readonly int $thisMonth,
        public readonly int $today,
    ) {}
}
