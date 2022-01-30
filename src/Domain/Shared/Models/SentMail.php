<?php

namespace Domain\Shared\Models;

use Domain\Shared\Builders\SentMailBuilder;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Query\Builder;

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
