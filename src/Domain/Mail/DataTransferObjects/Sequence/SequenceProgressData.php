<?php

namespace Domain\Mail\DataTransferObjects\Sequence;

use Spatie\LaravelData\Data;

class SequenceProgressData extends Data
{
    public function __construct(
        public readonly int $total,
        public readonly int $in_progress,
        public readonly int $completed,
    ) {}
}
