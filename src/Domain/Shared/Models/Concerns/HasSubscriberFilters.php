<?php

namespace Domain\Shared\Models\Concerns;

use Domain\Shared\DataTransferObjects\FilterData;
use Illuminate\Support\Collection;

interface HasSubscriberFilters
{
    /**
     * @return Collection<FilterData>
     */
    public function filters(): Collection;
}
