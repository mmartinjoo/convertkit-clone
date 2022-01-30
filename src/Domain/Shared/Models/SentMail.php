<?php

namespace Domain\Shared\Models;

use Domain\Subscriber\Models\Subscriber;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SentMail extends BaseModel
{
    public $timestamps = false;
    protected $fillable = [
        'mailable_id',
        'mailable_type',
        'subscriber_id',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(Subscriber::class);
    }

    public function mailable(): MorphTo
    {
        return $this->morphTo();
    }
}
