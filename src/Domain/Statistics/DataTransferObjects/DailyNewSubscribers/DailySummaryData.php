<?php

namespace Domain\Statistics\DataTransferObjects\DailyNewSubscribers;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class DailySummaryData extends Data
{
    public function __construct(
        public readonly int $total,
        /** @var DataCollection<DailyData> */
        public readonly DataCollection $daily,
    ) {}
}
