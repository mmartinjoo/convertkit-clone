<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Domain\Statistics\Actions\GetSubscribersCountStatisticsAction;
use Domain\Statistics\DataTransferObjects\SubscribersCountStatisticsData;

class GetSubscriberStatisticsController extends Controller
{
    public function __invoke(): SubscribersCountStatisticsData
    {
        return GetSubscribersCountStatisticsAction::execute();
    }
}
