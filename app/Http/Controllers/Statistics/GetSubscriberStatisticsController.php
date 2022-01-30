<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Domain\Statistics\Actions\GetSubscriberStatisticsAction;
use Domain\Statistics\DataTransferObjects\SubscriberStatisticsData;

class GetSubscriberStatisticsController extends Controller
{
    public function __invoke(): SubscriberStatisticsData
    {
        return GetSubscriberStatisticsAction::execute();
    }
}
