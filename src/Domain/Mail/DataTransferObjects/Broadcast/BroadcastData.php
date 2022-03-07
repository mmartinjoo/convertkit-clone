<?php

namespace Domain\Mail\DataTransferObjects\Broadcast;

use Carbon\Carbon;
use Domain\Mail\Enums\Broadcast\BroadcastStatus;
use Domain\Mail\DataTransferObjects\FilterData;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;

class BroadcastData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $subject,
        public readonly string $content,
        public readonly ?FilterData $filters,
        public readonly ?Carbon $sent_at,
        #[WithCast(EnumCast::class)]
        public readonly ?BroadcastStatus $status = BroadcastStatus::Draft,
    ) {}
}
