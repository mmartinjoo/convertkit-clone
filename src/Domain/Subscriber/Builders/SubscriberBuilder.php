<?php

namespace Domain\Subscriber\Builders;

use Domain\Sequence\Models\SequenceMail;
use Domain\Statistics\Filters\DateFilter;
use Illuminate\Database\Eloquent\Builder;

class SubscriberBuilder extends Builder
{
    /**
     * Subsriber has exactly the given tag IDs. No more, no less.
     */
    public function whereTagsExactly(array $ids): self
    {
        return $this->whereHas('tags', fn (Builder $tags) =>
            $tags->whereIn('id', $ids)
        )->whereDoesntHave('tags', fn (Builder $tags) =>
            $tags->whereNotIn('id', $ids)
        );
    }

    public function whereSubscribedBetween(DateFilter $dateFilter): self
    {
        return $this->whereBetween('created_at', $dateFilter->toArray());
    }

    public function alreadyReceived(SequenceMail $mail): bool
    {
        return $this->model->received_mails()->whereMailableId($mail->id)->exists();
    }
}
