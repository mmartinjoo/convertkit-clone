<?php

namespace Domain\Mail\DataTransferObjects\Sequence;

use Domain\Mail\Enums\Sequence\SequenceMailStatus;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Mail\DataTransferObjects\FilterData;
use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class SequenceMailData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $subject,
        public readonly string $content,
        #[WithCast(EnumCast::class)]
        public readonly SequenceMailStatus $status,
        public readonly FilterData $filters,
        public readonly null|Lazy|SequenceData $sequence,
        public readonly Lazy|SequenceMailScheduleData $schedule,
    ) {}

    public static function fromRequest(Request $request): self
    {
        // When creating a new one, the status and filters can be null in the request
        return self::from([
            ...$request->all(),
            'status' => $request->status ?? SequenceMailStatus::Draft,
            'filters' => $request->filters ?? FilterData::empty(),
        ]);
    }

    public static function fromModel(SequenceMail $sequenceMail): self
    {
        return self::from([
            ...$sequenceMail->toArray(),
            'sequence' => Lazy::whenLoaded('sequence', $sequenceMail, fn () => SequenceData::from($sequenceMail->sequence)),
            'schedule' => Lazy::whenLoaded('schedule', $sequenceMail, fn () => SequenceMailScheduleData::from($sequenceMail->schedule)),
        ]);
    }

    public static function dummy(): self
    {
        return self::from([
            'subject' => 'My Awesome E-mail',
            'content' => 'My Awesome Content',
            'status' => SequenceMailStatus::Draft,
            'filters' => FilterData::empty(),
            'schedule' => [
                'delay' => 1,
                'unit' => 'day',
                'allowed_days' => SequenceMailScheduleAllowedDaysData::empty(),
            ]
        ]);
    }
}
