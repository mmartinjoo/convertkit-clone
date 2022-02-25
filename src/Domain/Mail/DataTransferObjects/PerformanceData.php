<?php

namespace Domain\Mail\DataTransferObjects;

use Domain\Shared\ValueObjects\Percent;
use Spatie\LaravelData\Data;

class PerformanceData extends Data
{
    public function __construct(
        public readonly int $total,
        public readonly Percent $average_open_rate,
        public readonly Percent $average_click_rate,
    ) {}
}
