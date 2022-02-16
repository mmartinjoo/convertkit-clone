<?php

namespace Domain\Mail\DataTransferObjects\Sequence;

use Spatie\LaravelData\Data;

class SequenceMailScheduleDaysData extends Data
{
    public function __construct(
        public readonly bool $monday,
        public readonly bool $tuesday,
        public readonly bool $wednesday,
        public readonly bool $thursday,
        public readonly bool $friday,
        public readonly bool $saturday,
        public readonly bool $sunday,
    ) {}
}
