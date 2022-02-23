<?php

namespace Domain\Automation\ViewModels;

use Domain\Automation\DataTransferObjects\AutomationData;
use Domain\Automation\Enums\Actions;
use Domain\Automation\Enums\Events;
use Domain\Automation\Models\Automation;
use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Shared\ViewModels\ViewModel;
use Domain\Subscriber\DataTransferObjects\FormData;
use Domain\Subscriber\DataTransferObjects\TagData;
use Domain\Subscriber\Models\Form;
use Domain\Subscriber\Models\Tag;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CreateAutomationViewModel extends ViewModel
{
    public function __construct(private readonly ?Automation $automation = null)
    {
    }

    public function automation(): ?AutomationData
    {
        if (!$this->automation) {
            return null;
        }

        return AutomationData::from($this->automation->load('steps'));
    }

    /**
     * @return Collection<string, string>
     */
    public function events(): Collection
    {
        return collect(Events::cases())
            ->pluck('name')
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
            ->pluck('name')
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

    /**
     * @return Collection<TagData>
     */
    public function tags(): Collection
    {
        return Tag::all()->map(fn (Tag $tag) => TagData::from($tag));
    }

    /**
     * @return Collection<FormData>
     */
    public function forms(): Collection
    {
        return Form::all()->map(fn (Form $tag) => FormData::from($tag));
    }
}
