<?php

namespace Domain\Automation\ViewModels;

use Domain\Automation\DataTransferObjects\AutomationData;
use Domain\Automation\Models\Automation;
use Domain\Shared\ViewModels\ViewModel;
use Illuminate\Support\Collection;

class GetAutomationsViewModel extends ViewModel
{
    /**
     * @return Collection<AutomationData>
     */
    public function automations(): Collection
    {
        return Automation::with('steps')->get()->map->getData();
    }
}
