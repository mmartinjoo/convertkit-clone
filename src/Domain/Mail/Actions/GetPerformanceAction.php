<?php

namespace Domain\Mail\Actions;

use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Mail\Models\SentMail;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Report\DataTransferObjects\PerformanceData;
use Domain\Report\ValueObjects\Percent;

class GetPerformanceAction
{
    public static function execute(Broadcast|SequenceMail|Sequence $model): PerformanceData
    {
        if ($model instanceof Sequence) {
            $total = $model->activeSubscriberCount();
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
