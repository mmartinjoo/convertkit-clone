<?php

namespace Domain\Shared\ViewModels\Concerns;

use Domain\Subscriber\DataTransferObjects\TagData;
use Domain\Subscriber\Models\Tag;
use Illuminate\Support\Collection;

trait HasTags
{
    /**
     * @return Collection<TagData>
     */
    public function tags(): Collection
    {
        return Tag::all()->map->getData();
    }
}
