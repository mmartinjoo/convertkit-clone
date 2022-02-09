<?php

namespace Domain\Mail\DataTransferObjects\Sequence;

use Domain\Mail\Enums\Sequence\SequenceMailUnit;
use Domain\Mail\Models\Sequence\SequenceMailSchedule;
use Illuminate\Support\Arr;
use Spatie\LaravelData\Data;

class SequenceMailScheduleData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $delay,
        public readonly SequenceMailUnit $unit,
        /** @var array<int, int> */
        public readonly array $days,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id'),
            $data['delay'],
            SequenceMailUnit::from($data['unit']),
            $data['days'],
        );
    }

    public static function fromModel(SequenceMailSchedule $sequenceMailSchedule): self
    {
        return self::fromArray($sequenceMailSchedule->toArray());
    }
}
