<?php

namespace Domain\Shared\ViewModels\Concerns;

use Domain\Subscriber\DataTransferObjects\FormData;
use Domain\Subscriber\Models\Form;
use Illuminate\Support\Collection;

trait HasForms
{
    /**
     * @return Collection<FormData>
     */
    public function forms(): Collection
    {
        return Form::all()->map->getData();
    }
}
