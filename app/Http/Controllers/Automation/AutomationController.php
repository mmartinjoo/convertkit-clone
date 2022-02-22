<?php

namespace App\Http\Controllers\Automation;

use App\Http\Controllers\Controller;
use Domain\Automation\ViewModels\CreateAutomationViewModel;
use Domain\Automation\ViewModels\GetAutomationsViewModel;
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

    public function create(): Response
    {
        return Inertia::render('Automation/Form', [
            'model' => new CreateAutomationViewModel(),
        ]);
    }
}
