<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Domain\Shared\ViewModels\GetDashboardViewModel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class GetDashboardController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Dashboard', [
            'model' => new GetDashboardViewModel($request->user()),
        ]);
    }
}
