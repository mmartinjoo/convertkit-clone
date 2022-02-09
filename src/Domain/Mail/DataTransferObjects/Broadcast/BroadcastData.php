<?php

namespace Domain\Mail\DataTransferObjects\Broadcast;

use Carbon\Carbon;
use Domain\Mail\Enums\Broadcast\BroadcastStatus;
use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Shared\DataTransferObjects\FilterData;
use Illuminate\Http\Request;
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
        public readonly ?BroadcastStatus $status,
        public readonly ?Carbon $sent_at,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->all(),
            'status' => BroadcastStatus::DRAFT,
        ]);
    }

    public static function fromModel(Broadcast $broadcast): self
    {
        return self::from([
            ...$broadcast->toArray(),
            'status' => $broadcast->status,
        ]);
    }
}
