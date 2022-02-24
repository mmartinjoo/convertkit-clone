<?php

namespace Domain\Mail\Actions;

use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Mail\Models\SentMail;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Statistics\DataTransferObjects\PerformanceData;
use Domain\Statistics\ValueObjects\Percent;

class GetPerformanceAction
{
    public static function execute(Broadcast|SequenceMail|Sequence $model): PerformanceData
    {
        if ($model instanceof Sequence) {
            $total = $model->subscribers()->count();
        } else {
            $total = SentMail::getCountOf($model);
        }

        return new PerformanceData(
            total: $total,
            average_open_rate: SentMail::getAverageOpenRate($model, $total),
            average_click_rate: SentMail::getAverageClickRate($model, $total),
        );
    }
}
