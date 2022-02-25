<?php

namespace App\Http\Controllers\Automation;

use App\Http\Controllers\Controller;
use Domain\Automation\Actions\DeleteAutomationAction;
use Domain\Automation\Actions\UpsertAutomationAction;
use Domain\Automation\DataTransferObjects\AutomationData;
use Domain\Automation\Models\Automation;
use Domain\Automation\ViewModels\UpsertAutomationViewModel;
use Domain\Automation\ViewModels\GetAutomationsViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
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
            'model' => new UpsertAutomationViewModel(),
        ]);
    }

    public function store(AutomationData $data): RedirectResponse
    {
        UpsertAutomationAction::execute($data);

        return Redirect::route('automations.index');
    }

    public function edit(Automation $automation): Response
    {
        return Inertia::render('Automation/Form', [
            'model' => new UpsertAutomationViewModel($automation),
        ]);
    }

    public function update(AutomationData $data): RedirectResponse
    {
        UpsertAutomationAction::execute($data);

        return Redirect::route('automations.index');
    }

    public function destroy(Automation $automation): HttpResponse
    {
        DeleteAutomationAction::execute($automation);

        return response()->noContent();
    }
}
