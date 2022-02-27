<?php

namespace Domain\Subscriber\Builders;

use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Shared\Filters\DateFilter;
use Illuminate\Database\Eloquent\Builder;

class SubscriberBuilder extends Builder
{
    public function whereHasSomeTags(array $ids): self
    {
        return $this->whereHas('tags', fn (Builder $tags) =>
            $tags->whereIn('id', $ids)
        );
    }

    public function whereSubscribedBetween(DateFilter $dateFilter): self
    {
        return $this->whereBetween('subscribed_at', $dateFilter->toArray());
    }

    public function alreadyReceived(SequenceMail $mail): bool
    {
        return $this->model->received_mails()->whereSendableId($mail->id)->exists();
    }
}
