<?php

namespace Domain\Mail\DataTransferObjects\Sequence;

use Domain\Mail\Enums\Sequence\SequenceStatus;
use Domain\Mail\Models\Sequence\Sequence;
use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

class SequenceData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $title,
        #[WithCast(EnumCast::class)]
        public readonly SequenceStatus $status,
        /** @var DataCollection<SequenceMailData> */
        public readonly null|Lazy|DataCollection $mails,
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
            'mails' => Lazy::whenLoaded('mails', $sequence, fn () => SequenceMailData::collection($sequence->mails)),
        ]);
    }
}
