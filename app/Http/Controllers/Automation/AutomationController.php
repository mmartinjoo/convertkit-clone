<?php

namespace App\Http\Controllers\Automation;

use App\Http\Controllers\Controller;
use Domain\Automation\ViewModels\GetAutomationsViewModel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AutomationController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Automation/List', [
            'model' => new GetAutomationsViewModel(),
        ]);
    }
}
