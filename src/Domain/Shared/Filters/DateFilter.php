<?php

namespace Domain\Shared\Filters;

use Carbon\Carbon;

class DateFilter
{
    public function __construct(public readonly Carbon $startDate, public readonly Carbon $endDate)
    {
    }

    public static function today(): self
    {
        return new self(
            startDate: now()->startOfDay(),
            endDate: now(),
        );
    }

    public static function thisWeek(): self
    {
        return new self(
            startDate: now()->startOfWeek(),
            endDate: now(),
        );
    }

    public static function thisMonth(): self
    {
        return new self(
            startDate: now()->startOfMonth(),
            endDate: now(),
        );
    }

    public function toArray(): array
    {
        return [
            $this->startDate,
            $this->endDate
        ];
    }
}
