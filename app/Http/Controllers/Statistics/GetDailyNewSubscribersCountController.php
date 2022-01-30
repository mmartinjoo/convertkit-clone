<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Domain\Statistics\Actions\GetDailyNewSubscribersCountAction;
use Domain\Statistics\DataTransferObjects\DailyNewSubscribers\DailySummaryData;

class GetDailyNewSubscribersCountController extends Controller
{
    public function __invoke(): DailySummaryData
    {
        return GetDailyNewSubscribersCountAction::execute();
    }
}
