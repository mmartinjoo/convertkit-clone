<?php

namespace Domain\Sequence\DataTransferObjects;

use Domain\Sequence\Enums\SequenceStatus;
use Domain\Sequence\Models\Sequence;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class SequenceData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $title,
        public readonly ?SequenceStatus $status,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->all(),
            'status' => SequenceStatus::DRAFT,
        ]);
    }

    public static function fromModel(Sequence $sequence): self
    {
        return self::from([
            ...$sequence->toArray(),
            'status' => $sequence->status,
        ]);
    }
}
