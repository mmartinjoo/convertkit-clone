<?php

namespace Domain\Subscriber\Builders;

use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Statistics\Filters\DateFilter;
use Illuminate\Database\Eloquent\Builder;

class SubscriberBuilder extends Builder
{
    public function whereTagsExactly(array $ids): self
    {
        return $this->has('tags', '=', count($ids))
            ->whereHas('tags', fn (Builder $tags) => $tags->whereKey($ids));
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
