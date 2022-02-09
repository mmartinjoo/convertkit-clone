<?php

namespace Domain\Mail\DataTransferObjects\Sequence;

use Domain\Mail\Enums\Sequence\SequenceStatus;
use Domain\Mail\Models\Sequence\Sequence;
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
            'status' => SequenceStatus::Draft,
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
