<?php

namespace Domain\Statistics\DataTransferObjects;

use Domain\Statistics\ValueObjects\Percent;
use Spatie\LaravelData\Data;

class PerformanceData extends Data
{
    public function __construct(
        public readonly int $total,
        public readonly Percent $average_open_rate,
        public readonly Percent $average_click_rate,
    ) {}
}
