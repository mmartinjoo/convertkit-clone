<?php

namespace Domain\Automation\ViewModels;

use Domain\Automation\Enums\Actions;
use Domain\Automation\Enums\Events;
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
    /**
     * @return Collection<string>
     */
    public function events(): Collection
    {
        return collect(Events::cases())
            ->pluck('name')
            ->map(fn (string $name) => Str::of($name)->snake()->title()->replace('_', ' '));
    }

    /**
     * @return Collection<string>
     */
    public function actions(): Collection
    {
        return collect(Actions::cases())
            ->pluck('name')
            ->map(fn (string $name) => Str::of($name)->snake()->title()->replace('_', ' '));
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
