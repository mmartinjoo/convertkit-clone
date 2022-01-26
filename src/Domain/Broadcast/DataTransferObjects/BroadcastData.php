<?php

namespace Domain\Broadcast\DataTransferObjects;

use Carbon\Carbon;
use Domain\Broadcast\Enums\BroadcastStatus;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class BroadcastData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $title,
        public readonly string $content,
        /** @var DataCollection<BroadcastFilterData> */
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
}
