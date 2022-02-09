<?php

namespace Domain\Mail\Builders\Sequence;

use Domain\Mail\Enums\Sequence\SequenceMailStatus;
use Illuminate\Database\Eloquent\Builder;

class SequenceMailBuilder extends Builder
{
    public function wherePublished(): self
    {
        return $this->whereStatus(SequenceMailStatus::Published);
    }
}
