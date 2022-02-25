<?php

namespace Domain\Mail\Models\Sequence;

use Domain\Mail\Enums\Sequence\SubscriberStatus;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SequenceSubscriber extends Pivot
{
    public $incrementing = true;

    protected $fillable = [
        'sequence_id',
        'subscriber_id',
        'status',
    ];

    protected $casts = [
        'status' => SubscriberStatus::class,
    ];
}
