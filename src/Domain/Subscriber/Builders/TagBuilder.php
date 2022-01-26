<?php

namespace Domain\Subscriber\Builders;

use Domain\Subscriber\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class TagBuilder extends Builder
{
    /**
     * @param Collection<string>
     * @return Collection<Tag>
     */
    // public function getOrCreateMany(Collection $names): Collection
    // {
    //     return $names->map(fn (string $name) => Tag::firstOrCreate(['title' => $title]));
    // }
}
