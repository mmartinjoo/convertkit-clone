<?php

namespace Domain\Statistics\DataTransferObjects\SentMails;

use Spatie\LaravelData\Data;

class SentMailsTrackingData extends Data
{
    public function __construct(
        public readonly int $total_sent_mails,
        public readonly float $average_open_rate,
        public readonly float $average_click_rate,
    ) {}
}
