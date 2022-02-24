<?php

namespace Domain\Report\DataTransferObjects;

use Domain\Report\ValueObjects\Percent;
use Spatie\LaravelData\Data;

class PerformanceData extends Data
{
    public function __construct(
        public readonly int $total,
        public readonly Percent $average_open_rate,
        public readonly Percent $average_click_rate,
    ) {}
}
