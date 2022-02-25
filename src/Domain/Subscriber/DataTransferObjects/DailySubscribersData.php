<?php

namespace Domain\Subscriber\DataTransferObjects;

use Spatie\LaravelData\Data;

class DailySubscribersData extends Data
{
    public function __construct(
        public readonly string $day,
        public readonly int $count,
    ) {}
}
