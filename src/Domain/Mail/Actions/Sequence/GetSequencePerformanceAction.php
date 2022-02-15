<?php

namespace Domain\Mail\Actions\Sequence;

use Domain\Mail\Contracts\Sendable;
use Domain\Mail\Models\SentMail;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Statistics\DataTransferObjects\Tracking\TrackingData;
use Domain\Statistics\ValueObjects\Percent;
use Illuminate\Database\Eloquent\Builder;

class GetSequencePerformanceAction
{
    public static function execute(Sequence $sequence): TrackingData
    {
        $total = self::sentMail($sequence)->count();

        if ($total === 0) {
            return new TrackingData(
                total_sent_mails: 0,
                average_open_rate: Percent::from(0),
                average_click_rate: Percent::from(0),
            );
        }

        return new TrackingData(
            total_sent_mails: $total,
            average_open_rate: self::averageOpenRate($total, $sequence),
            average_click_rate: self::averageClickRate($total, $sequence),
        );
    }

    private static function averageOpenRate(int $total, Sequence $sequence): Percent
    {
        return Percent::from(
            self::sentMail($sequence)
                ->whereOpened()
                ->count() / $total
        );
    }

    private static function averageClickRate(int $total, Sequence $sequence): Percent
    {
        return Percent::from(
            self::sentMail($sequence)
                ->whereClicked()
                ->count() / $total
        );
    }

    private static function sentMail(Sequence $sequence): Builder
    {
        return SentMail::query()
            ->whereIn('mailable_id', $sequence->mails->pluck('id'))
            ->where('mailable_type', SequenceMail::class);
    }
}
