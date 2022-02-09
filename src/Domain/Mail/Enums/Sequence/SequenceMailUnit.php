<?php

namespace Domain\Mail\Enums\Sequence;

use Carbon\Carbon;

enum SequenceMailUnit: string
{
    case DAY = 'day';
    case HOUR = 'hour';

    public function timePassed(?Carbon $since): int
    {
        if (!$since) {
            return true;
        }

        return match ($this) {
            self::DAY => now()->diffInDays($since),
            self::HOUR => now()->diffInHours($since),
        };
    }
}
