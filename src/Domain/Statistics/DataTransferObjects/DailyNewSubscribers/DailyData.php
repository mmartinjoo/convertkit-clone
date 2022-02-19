<?php

namespace Domain\Statistics\DataTransferObjects\DailyNewSubscribers;

use Spatie\LaravelData\Data;

class DailyData extends Data
{
    public function __construct(
        public readonly string $day,
        public readonly int $count,
    ) {}
}
