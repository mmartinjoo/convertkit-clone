<?php

namespace Domain\Mail\Models\Sequence;

use Domain\Mail\Enums\Sequence\SubscriberStatus;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SequenceSubscriber extends Pivot
{
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'sequence_id',
        'subscriber_id',
        'status',
    ];

    protected $casts = [
        'status' => SubscriberStatus::class,
    ];

    public function sequence(): BelongsTo
    {
        return $this->belongsTo(Sequence::class);
    }

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(Subscriber::class);
    }
}
