<?php

namespace Domain\Mail\Enums\Sequence;

use Carbon\Carbon;

enum SequenceMailUnit: string
{
    case Day = 'day';
    case Hour = 'hour';

    public function timePassed(?Carbon $since): int
    {
        if (!$since) {
            return true;
        }

        return match ($this) {
            self::Day => now()->diffInDays($since),
            self::Hour => now()->diffInHours($since),
        };
    }
}
