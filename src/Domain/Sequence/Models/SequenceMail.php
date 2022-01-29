<?php

namespace Domain\Sequence\Models;

use Domain\Sequence\Enums\SequenceMailStatus;
use Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SequenceMail extends BaseModel
{
    protected $fillable = [
        'sequence_id',
        'title',
        'content',
        'status',
        'filters',
        'status',
    ];

    protected $casts = [
        'status' => SequenceMailStatus::class,
    ];

    protected $attributes = [
        'status' => SequenceMailStatus::DRAFT,
    ];

    public function sequence(): BelongsTo
    {
        return $this->belongsTo(Sequence::class);
    }
}
