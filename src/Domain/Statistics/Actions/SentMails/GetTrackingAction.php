<?php

namespace Domain\Statistics\Actions\SentMails;

use Domain\Shared\Models\Concerns\Sendable;
use Domain\Shared\Models\SentMail;
use Domain\Statistics\DataTransferObjects\Tracking\TrackingData;
use Domain\Statistics\ValueObjects\Percent;
use Illuminate\Database\Eloquent\Builder;

class GetTrackingAction
{
    public static function execute(Sendable $sendable): TrackingData
    {
        $total = self::sentMail($sendable)->count();

        return new TrackingData(
            total_sent_mails: $total,
            average_open_rate: self::averageOpenRate($sendable, $total),
            average_click_rate: self::averageClickRate($sendable, $total),
        );
    }

    private static function averageOpenRate(Sendable $sendable, int $total): Percent
    {
        return Percent::from(
            self::sentMail($sendable)
                ->whereOpened()
                ->count() / $total
        );
    }

    private static function averageClickRate(Sendable $sendable, int $total): Percent
    {
        return Percent::from(
            self::sentMail($sendable)
                ->whereClicked()
                ->count() / $total
        );
    }

    private static function sentMail(Sendable $sendable): Builder
    {
        return SentMail::query()
            ->where('mailable_id', $sendable->id())
            ->where('mailable_type', $sendable->type());
    }
}
