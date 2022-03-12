<?php

namespace Domain\Mail\Enums\Sequence;

use Carbon\Carbon;

enum SequenceMailUnit: string
{
    case Day = 'day';
    case Hour = 'hour';

    public function timePassedSince(?Carbon $date): int
    {
        if (!$date) {
            return PHP_INT_MAX;
        }

        return match ($this) {
            self::Day => now()->diffInDays($date),
            self::Hour => now()->diffInHours($date),
        };
    }
}
