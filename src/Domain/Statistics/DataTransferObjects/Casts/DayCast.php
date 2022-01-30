<?php

namespace Domain\Statistics\DataTransferObjects\Casts;

use Carbon\Carbon;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class DayCast implements Cast
{
    public function cast(DataProperty $property, mixed $value): Carbon
    {
        return Carbon::parse($value);
    }
}
