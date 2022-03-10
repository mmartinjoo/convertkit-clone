<?php

namespace Domain\Mail\Actions;

use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Mail\Models\SentMail;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Mail\DataTransferObjects\PerformanceData;

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
            open_rate: SentMail::getOpenRate($model, $total),
            click_rate: SentMail::getClickRate($model, $total),
        );
    }
}
