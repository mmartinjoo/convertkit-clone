<?php

namespace Domain\Statistics\Actions;

use Domain\Statistics\DataTransferObjects\NewSubscribersCountData;
use Domain\Statistics\Filters\DateFilter;
use Domain\Subscriber\Models\Subscriber;

class GetNewSubscribersCountAction
{
    public static function execute(): NewSubscribersCountData
    {
        return new NewSubscribersCountData(
            total: Subscriber::count(),
            thisWeek: Subscriber::whereSubscribedBetween(DateFilter::thisWeek())->count(),
            thisMonth: Subscriber::whereSubscribedBetween(DateFilter::thisMonth())->count(),
            today: Subscriber::whereSubscribedBetween(DateFilter::today())->count(),
        );
    }
}