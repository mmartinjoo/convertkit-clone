<?php

namespace Domain\Automation\ViewModels;

use Domain\Automation\DataTransferObjects\AutomationData;
use Domain\Automation\Enums\Actions;
use Domain\Automation\Enums\Events;
use Domain\Automation\Models\Automation;
use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Shared\ViewModels\Concerns\HasForms;
use Domain\Shared\ViewModels\Concerns\HasTags;
use Domain\Shared\ViewModels\ViewModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class UpsertAutomationViewModel extends ViewModel
{
    use HasTags;
    use HasForms;

    public function __construct(private readonly ?Automation $automation = null)
    {
    }

    public function automation(): ?AutomationData
    {
        if (!$this->automation) {
            return null;
        }

        return $this->automation->load('steps')->getData();
    }

    /**
     * @return Collection<string, string>
     */
    public function events(): Collection
    {
        return collect(Events::cases())
            ->pluck('value')
            ->mapWithKeys(fn (string $name) =>
                [$name => Str::of($name)->snake()->title()->replace('_', ' ')]
            );
    }

    /**
     * @return Collection<string, string>
     */
    public function actions(): Collection
    {
        return collect(Actions::cases())
            ->pluck('value')
            ->mapWithKeys(fn (string $name) =>
                [$name => Str::of($name)->snake()->title()->replace('_', ' ')]
            );
    }

    /**
     * @return Collection<SequenceData>
     */
    public function sequences(): Collection
    {
        return Sequence::all()->map(fn (Sequence $sequence) => SequenceData::from($sequence));
    }
}
