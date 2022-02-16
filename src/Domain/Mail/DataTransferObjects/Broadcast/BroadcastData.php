<?php

namespace Domain\Mail\DataTransferObjects\Broadcast;

use Carbon\Carbon;
use Domain\Mail\Enums\Broadcast\BroadcastStatus;
use Domain\Mail\DataTransferObjects\FilterData;
use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class BroadcastData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $subject,
        public readonly string $content,
        /** @var DataCollection<FilterData> */
        public readonly ?DataCollection $filters,
        #[WithCast(EnumCast::class)]
        public readonly ?BroadcastStatus $status,
        public readonly ?Carbon $sent_at,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->all(),
            'status' => $request->status ?: BroadcastStatus::Draft,
            'filters' => FilterData::collectionFromRequest($request),
        ]);
    }
}
