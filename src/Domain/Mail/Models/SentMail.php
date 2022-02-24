<?php

namespace Domain\Mail\Models;

use Domain\Mail\Builders\SentMail\SentMailBuilder;
use Domain\Shared\Models\BaseModel;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SentMail extends BaseModel
{
    public $timestamps = false;

    protected $fillable = [
        'sendable_id',
        'sendable_type',
        'subscriber_id',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function newEloquentBuilder($query): SentMailBuilder
    {
        return new SentMailBuilder($query);
    }

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(Subscriber::class);
    }

    public function mailable(): MorphTo
    {
        return $this->morphTo();
    }
}
