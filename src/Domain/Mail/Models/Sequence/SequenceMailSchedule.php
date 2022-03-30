<?php

namespace Domain\Mail\Models\Sequence;

use Domain\Mail\Enums\Sequence\SequenceMailUnit;
use Domain\Mail\Models\Casts\Sequence\SequenceMailScheduleAllowedDaysCast;
use Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SequenceMailSchedule extends BaseModel
{
    protected $fillable = [
        'delay',
        'unit',
        'allowed_days',
        'sequence_mail_id',
    ];

    protected $casts = [
        'allowed_days' => SequenceMailScheduleAllowedDaysCast::class,
        'unit' => SequenceMailUnit::class,
    ];

    public function sequence_mail(): BelongsTo
    {
        return $this->belongsTo(SequenceMail::class);
    }

    public function delayInHours(): int
    {
        if ($this->unit === SequenceMailUnit::Day) {
            return $this->delay * 24;
        }

        return $this->delay;
    }
}
