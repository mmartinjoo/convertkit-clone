<?php

namespace Domain\Statistics\Actions;

use Domain\Statistics\DataTransferObjects\SubscriberStatisticsData;
use Domain\Statistics\Filters\DateFilter;
use Domain\Subscriber\Models\Subscriber;

class GetSubscriberStatisticsAction
{
    public static function execute(): SubscriberStatisticsData
    {
        return new SubscriberStatisticsData(
            total: Subscriber::count(),
            thisWeek: Subscriber::whereSubscribedBetween(DateFilter::thisWeek())->count(),
            thisMonth: Subscriber::whereSubscribedBetween(DateFilter::thisMonth())->count(),
            today: Subscriber::whereSubscribedBetween(DateFilter::today())->count(),
        );
    }
}
