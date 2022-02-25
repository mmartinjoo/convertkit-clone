<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Domain\Shared\ViewModels\GetDashboardViewModel;
use Inertia\Inertia;
use Inertia\Response;

class GetDashboardController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Dashboard', [
            'model' => new GetDashboardViewModel(),
        ]);
    }
}
