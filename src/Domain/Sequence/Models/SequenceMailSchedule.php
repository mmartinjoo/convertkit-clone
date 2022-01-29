<?php

namespace Domain\Sequence\Models;

use Carbon\Carbon;
use Domain\Sequence\Enums\SequenceMailUnit;
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
        'days' => 'array',
        'unit' => SequenceMailUnit::class,
    ];

    public function mail(): HasOne
    {
        return $this->hasOne(SequenceMail::class);
    }

    public function timePased(Carbon $since): int
    {
        return $this->unit->timePased($since);
    }
}
