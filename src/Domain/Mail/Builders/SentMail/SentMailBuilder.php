<?php

namespace Domain\Mail\Builders\SentMail;

use Domain\Mail\Contracts\Sendable;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Illuminate\Database\Eloquent\Builder;

class SentMailBuilder extends Builder
{
    public function whereOpened(): self
    {
        return $this->whereNotNull('opened_at');
    }

    public function whereClicked(): self
    {
        return $this->whereNotNull('clicked_at');
    }

    public function whereSendable(Sendable $sendable): self
    {
        return $this
            ->where('sendable_id', $sendable->id())
            ->where('sendable_type', $sendable->type());
    }

    public function whereSequence(Sequence $sequence): self
    {
        return $this
            ->whereIn('sendable_id', $sequence->mails->pluck('id'))
            ->where('sendable_type', SequenceMail::class);
    }

    public function countOf(Sendable $model): int
    {
        return $this->whereSendable($model)->count();
    }
}
