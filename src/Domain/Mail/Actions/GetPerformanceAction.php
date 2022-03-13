<?php

namespace Domain\Mail\Actions;

use Domain\Mail\Contracts\Measurable;
use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Mail\Models\SentMail;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Mail\DataTransferObjects\PerformanceData;

class GetPerformanceAction
{
    public static function execute(Measurable $model): PerformanceData
    {
//        if ($model instanceof Sequence) {
//            $total = $model->activeSubscriberCount();
//        } else {
//            $total = SentMail::getCountOf($model);
//        }

        $total = $model->totalInstances();

        return new PerformanceData(
            total: $total,
            open_rate: SentMail::getOpenRate($model, $total),
            click_rate: SentMail::getClickRate($model, $total),
        );
    }
}
