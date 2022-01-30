<?php

namespace Domain\Statistics\Actions;

use Domain\Statistics\DataTransferObjects\SubscribersCountStatisticsData;
use Domain\Statistics\Filters\DateFilter;
use Domain\Subscriber\Models\Subscriber;

class GetSubscribersCountStatisticsAction
{
    public static function execute(): SubscribersCountStatisticsData
    {
        return new SubscribersCountStatisticsData(
            total: Subscriber::count(),
            thisWeek: Subscriber::whereSubscribedBetween(DateFilter::thisWeek())->count(),
            thisMonth: Subscriber::whereSubscribedBetween(DateFilter::thisMonth())->count(),
            today: Subscriber::whereSubscribedBetween(DateFilter::today())->count(),
        );
    }
}
