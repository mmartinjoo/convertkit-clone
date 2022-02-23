<?php

namespace App\Http\Controllers\Automation;

use App\Http\Controllers\Controller;
use Domain\Automation\Actions\UpsertAutomationAction;
use Domain\Automation\DataTransferObjects\AutomationData;
use Domain\Automation\Models\Automation;
use Domain\Automation\ViewModels\CreateAutomationViewModel;
use Domain\Automation\ViewModels\GetAutomationsViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Redirect;

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

    public function store(Request $request): RedirectResponse
    {
        UpsertAutomationAction::execute(AutomationData::fromRequest($request));

        return Redirect::route('automations.index');
    }

    public function edit(Automation $automation): Response
    {
        return Inertia::render('Automation/Form', [
            'model' => new CreateAutomationViewModel($automation),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        UpsertAutomationAction::execute(AutomationData::fromRequest($request));

        return Redirect::route('automations.index');
    }
}
