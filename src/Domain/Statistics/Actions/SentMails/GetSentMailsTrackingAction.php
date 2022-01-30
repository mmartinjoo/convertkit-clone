<?php

namespace Domain\Statistics\Actions\SentMails;

use Domain\Shared\Models\SentMail;
use Domain\Statistics\DataTransferObjects\Tracking\TrackingData;
use Domain\Statistics\ValueObjects\Percent;

class GetSentMailsTrackingAction
{
    public static function execute(): TrackingData
    {
        $total = SentMail::count();

        return new TrackingData(
            total_sent_mails: $total,
            average_open_rate: self::averageOpenRate($total),
            average_click_rate: self::averageClickRate($total),
        );
    }

    private static function averageOpenRate(int $total): Percent
    {
        return Percent::from(
            SentMail::whereOpened()->count() / $total
        );
    }

    private static function averageClickRate(int $total): Percent
    {
        return Percent::from(
            SentMail::whereClicked()->count() / $total
        );
    }
}
