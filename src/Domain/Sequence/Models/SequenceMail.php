<?php

namespace Domain\Sequence\Models;

use Domain\Sequence\Enums\SequenceMailStatus;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Casts\FiltersCast;
use Domain\Shared\Models\SentMail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class SequenceMail extends BaseModel
{
    protected $fillable = [
        'sequence_id',
        'sequence_mail_schedule_id',
        'title',
        'content',
        'status',
        'filters',
        'status',
    ];

    protected $casts = [
        'status' => SequenceMailStatus::class,
        'filters' => FiltersCast::class,
    ];

    protected $attributes = [
        'status' => SequenceMailStatus::DRAFT,
    ];

    public function sequence(): BelongsTo
    {
        return $this->belongsTo(Sequence::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(SequenceMailSchedule::class, 'sequence_mail_schedule_id');
    }

    public function sent_mails(): MorphMany
    {
        return $this->morphMany(SentMail::class, 'mailable');
    }
}
