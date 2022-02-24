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
            $total = $model->getSubscriberCount();
        } else {
            $total = SentMail::getCountOf($model);
        }

        if ($total === 0) {
            return new PerformanceData(
                total: 0,
                average_open_rate: Percent::from(0),
                average_click_rate: Percent::from(0),
            );
        }

        return new PerformanceData(
            total: $total,
            average_open_rate: SentMail::getAverageOpenRate($model, $total),
            average_click_rate: SentMail::getAverageClickRate($model, $total),
        );
    }
}
