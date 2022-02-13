<?php

namespace Domain\Statistics\DataTransferObjects;

use Spatie\LaravelData\Data;

class NewSubscribersCountData extends Data
{
    public function __construct(
        public readonly int $total,
        public readonly int $this_week,
        public readonly int $this_month,
        public readonly int $today,
    ) {}
}
