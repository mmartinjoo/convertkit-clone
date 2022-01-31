<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Domain\Statistics\DataTransferObjects\DailyNewSubscribers\DailySummaryData;
use Domain\Statistics\ViewModels\GetDailySubscribersViewModel;

class GetDailySubscribersController extends Controller
{
    public function __invoke(): DailySummaryData
    {
        $viewModel = new GetDailySubscribersViewModel();
        return $viewModel();
    }
}
