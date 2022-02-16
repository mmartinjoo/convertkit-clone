<?php

namespace Domain\Mail\Models\Sequence;

use Carbon\Carbon;
use Domain\Mail\Enums\Sequence\SequenceMailUnit;
use Domain\Mail\Models\Casts\Sequence\SequenceMailScheduleDaysCast;
use Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SequenceMailSchedule extends BaseModel
{
    protected $fillable = [
        'delay',
        'unit',
        'days',
    ];

    protected $casts = [
        'days' => SequenceMailScheduleDaysCast::class,
        'unit' => SequenceMailUnit::class,
    ];

    public function mail(): HasOne
    {
        return $this->hasOne(SequenceMail::class);
    }
}
