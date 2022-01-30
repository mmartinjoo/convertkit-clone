<?php

namespace Domain\Sequence\Builders;

use Domain\Sequence\Enums\SequenceMailStatus;
use Illuminate\Database\Eloquent\Builder;

class SequenceMailBuilder extends Builder
{
    public function wherePublished(): self
    {
        return $this->whereStatus(SequenceMailStatus::PUBLISHED);
    }
}
