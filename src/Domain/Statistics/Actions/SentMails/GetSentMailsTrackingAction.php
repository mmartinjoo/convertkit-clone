<?php

namespace Domain\Statistics\Actions\SentMails;

use Domain\Shared\Models\SentMail;
use Domain\Statistics\DataTransferObjects\SentMails\SentMailsTrackingData;

class GetSentMailsTrackingAction
{
    public static function execute(): SentMailsTrackingData
    {
        $total = SentMail::count();

        return new SentMailsTrackingData(
            total_sent_mails: $total,
            average_open_rate: self::averageOpenRate($total),
            average_click_rate: self::averageClickRate($total),
        );
    }

    private static function averageOpenRate(int $total): float
    {
        return SentMail::whereOpened()->count() / $total;
    }

    private static function averageClickRate(int $total): float
    {
        return SentMail::whereClicked()->count() / $total;
    }
}
