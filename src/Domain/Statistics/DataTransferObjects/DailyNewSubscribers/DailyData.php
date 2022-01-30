<?php

namespace Domain\Statistics\DataTransferObjects\DailyNewSubscribers;

use Carbon\Carbon;
use Domain\Statistics\DataTransferObjects\Casts\DayCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\WithCast;

class DailyData extends Data
{
    public function __construct(
        #[WithCast(DayCast::class)]
        public readonly Carbon $day,
        public readonly int $count,
    ) {}
}
