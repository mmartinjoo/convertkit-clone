<?php

namespace Domain\Mail\Models\Sequence;

use Domain\Mail\Enums\Sequence\SubscriberStatus;
use Domain\Shared\Models\BaseModel;

class SequenceSubscriber extends BaseModel
{
    protected $table = 'sequence_subscriber';

    protected $fillable = [
        'sequence_id',
        'subscriber_id',
        'status',
    ];

    protected $casts = [
        'status' => SubscriberStatus::class,
    ];
}
