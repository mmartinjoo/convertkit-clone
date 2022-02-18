<?php

namespace Domain\Mail\Models\Concerns;

use Domain\Mail\Models\SentMail;
use Domain\Statistics\DataTransferObjects\Tracking\TrackingData;
use Domain\Statistics\ValueObjects\Percent;

trait HasPerformance
{
    public function getPerformance(): TrackingData
    {
        $total = SentMail::getCountOf($this);

        if ($total === 0) {
            return new TrackingData(
                total_sent_mails: 0,
                average_open_rate: Percent::from(0),
                average_click_rate: Percent::from(0),
            );
        }

        return new TrackingData(
            total_sent_mails: $total,
            average_open_rate: SentMail::getAverageOpenRate($this, $total),
            average_click_rate: SentMail::getAverageClickRate($this, $total),
        );
    }
}
