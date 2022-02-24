<?php

namespace Domain\Mail\Builders\SentMail;

use Domain\Mail\Contracts\Sendable;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Report\ValueObjects\Percent;
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
            ->where('mailable_id', $sendable->id())
            ->where('mailable_type', $sendable->type());
    }

    public function whereSequence(Sequence $sequence): self
    {
        return $this
            ->whereIn('mailable_id', $sequence->mails->pluck('id'))
            ->where('mailable_type', SequenceMail::class);
    }

    public function getCountOf(Sendable $model): int
    {
        return $this->whereSendable($model)->count();
    }

    public function getAverageOpenRate(Sendable|Sequence $model, int $total): Percent
    {
        $query = $model instanceof Sequence
            ? $this->whereSequence($model)
            : $this->whereSendable($model);

        return Percent::from(
            $query->whereOpened()->count(), $total
        );
    }

    public function getAverageClickRate(Sendable|Sequence $model, int $total): Percent
    {
        $query = $model instanceof Sequence
            ? $this->whereSequence($model)
            : $this->whereSendable($model);

        return Percent::from(
            $query->whereClicked()->count(), $total
        );
    }
}
