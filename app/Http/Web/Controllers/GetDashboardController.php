<?php

namespace App\Http\Web\Controllers;

use Domain\Shared\ViewModels\GetDashboardViewModel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class GetDashboardController
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Dashboard', [
            'model' => new GetDashboardViewModel($request->user()),
        ]);
    }
}
