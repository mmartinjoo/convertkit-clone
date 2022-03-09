<?php

namespace Domain\Mail\Models;

use Domain\Mail\Builders\SentMail\SentMailBuilder;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SentMail extends BaseModel
{
    use HasUser;

    public $timestamps = false;

    protected $fillable = [
        'sendable_id',
        'sendable_type',
        'subscriber_id',
        'user_id',
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

    public function sendable(): MorphTo
    {
        return $this->morphTo();
    }
}
