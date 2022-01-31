<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Domain\Statistics\ViewModels\GetDashboardViewModel;

class GetDashboardController extends Controller
{
    public function __invoke(): GetDashboardViewModel
    {
        return new GetDashboardViewModel();
    }
}
