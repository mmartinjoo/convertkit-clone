<?php

namespace Domain\Mail\Models\Casts\Sequence;

use Domain\Mail\DataTransferObjects\Sequence\SequenceMailScheduleDaysData;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class SequenceMailScheduleDaysCast implements CastsAttributes
{

    public function get($model, string $key, $value, array $attributes)
    {
        return SequenceMailScheduleDaysData::from(json_decode($value, true));
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return [
            'days' => json_encode($value),
        ];
    }
}
