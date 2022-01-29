<?php

namespace Domain\Sequence\DataTransferObjects;

use Domain\Sequence\Enums\SequenceMailStatus;
use Domain\Sequence\Models\SequenceMail;
use Domain\Shared\DataTransferObjects\FilterData;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

class SequenceMailData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $title,
        public readonly string $content,
        public readonly ?SequenceMailStatus $status,
        /** @var DataCollection<FilterData> */
        public readonly ?DataCollection $filters,
        public readonly null|Lazy|SequenceData $sequence,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->all(),
            'status' => SequenceMailStatus::DRAFT,
        ]);
    }

    public static function fromModel(SequenceMail $sequenceMail): self
    {
        return self::from([
            ...$sequenceMail->toArray(),
            'status' => $sequenceMail->status,
            'sequence' => Lazy::whenLoaded('sequence', $sequenceMail, fn () => SequenceData::from($sequenceMail->sequence)),
        ]);
    }
}