<?php

namespace Domain\Statistics\DataTransferObjects\Tracking;

use Domain\Statistics\ValueObjects\Percent;
use Spatie\LaravelData\Data;

class TrackingData extends Data
{
    public function __construct(
        public readonly int $total_sent_mails,
        public readonly Percent $average_open_rate,
        public readonly Percent $average_click_rate,
    ) {}
}
