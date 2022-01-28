<?php

namespace Domain\Subscriber\Builders;

use Illuminate\Database\Eloquent\Builder;

class SubscriberBuilder extends Builder
{
    /**
     * Match means that subsriber has exactly the given tag IDs. No more, no less.
     */
    public function whereIdMatches(array $ids): self
    {
        return $this->whereHas('tags', fn (Builder $tags) =>
            $tags->whereIn('id', $ids)
        )->whereDoesntHave('tags', fn (Builder $tags) =>
            $tags->whereNotIn('id', $ids)
        );
    }
}
