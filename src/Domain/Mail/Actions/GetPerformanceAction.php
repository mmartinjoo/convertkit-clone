<?php

namespace Domain\Mail\Actions;

use Domain\Mail\Contracts\Sendable;
use Domain\Mail\Models\SentMail;
use Domain\Statistics\DataTransferObjects\Tracking\TrackingData;
use Domain\Statistics\ValueObjects\Percent;
use Illuminate\Database\Eloquent\Builder;

class GetPerformanceAction
{
    public static function execute(Sendable $sendable): TrackingData
    {
        $total = self::sentMail($sendable)->count();

        if ($total === 0) {
            return new TrackingData(
                total_sent_mails: 0,
                average_open_rate: Percent::from(0),
                average_click_rate: Percent::from(0),
            );
        }

        return new TrackingData(
            total_sent_mails: $total,
            average_open_rate: self::averageOpenRate($total, $sendable),
            average_click_rate: self::averageClickRate($total, $sendable),
        );
    }

    private static function averageOpenRate(int $total, Sendable $sendable): Percent
    {
        return Percent::from(
            self::sentMail($sendable)
                ->whereOpened()
                ->count() / $total
        );
    }

    private static function averageClickRate(int $total, Sendable $sendable): Percent
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
