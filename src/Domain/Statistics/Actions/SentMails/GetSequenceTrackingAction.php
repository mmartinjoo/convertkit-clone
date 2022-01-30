<?php

namespace Domain\Statistics\Actions\SentMails;

use Domain\Sequence\Models\Sequence;
use Domain\Sequence\Models\SequenceMail;
use Domain\Shared\Models\SentMail;
use Domain\Statistics\DataTransferObjects\Tracking\TrackingData;
use Domain\Statistics\ValueObjects\Percent;
use Illuminate\Database\Eloquent\Builder;

class GetSequenceTrackingAction
{
    public static function execute(Sequence $sequence): TrackingData
    {
        $total = self::sentMails($sequence)->count();

        return new TrackingData(
            total_sent_mails: $total,
            average_open_rate: self::averageOpenRate($sequence, $total),
            average_click_rate: self::averageClickRate($sequence, $total),
        );
    }

    private static function averageOpenRate(Sequence $sequence, int $total): Percent
    {
        return Percent::from(
            self::sentMails($sequence)
                ->whereOpened()
                ->count() / $total
        );
    }

    private static function averageClickRate(Sequence $sequence, int $total): Percent
    {
        return Percent::from(
            self::sentMails($sequence)
                ->whereClicked()
                ->count() / $total
        );
    }

    private static function sentMails(Sequence $sequence): Builder
    {
        return SentMail::query()
            ->whereIn('mailable_id', $sequence->mails()->pluck('id'))
            ->where('mailable_type', SequenceMail::class);
    }
}
