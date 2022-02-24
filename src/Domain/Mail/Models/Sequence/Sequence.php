<?php

namespace Domain\Mail\Models\Sequence;

use Domain\Mail\Builders\Sequence\SequenceBuilder;
use Domain\Mail\Enums\Sequence\SequenceStatus;
use Domain\Mail\Models\SentMail;
use Domain\Shared\Models\BaseModel;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Sequence extends BaseModel
{
    protected $fillable = [
        'title',
        'status',
    ];

    protected $casts = [
        'status' => SequenceStatus::class,
    ];

    protected $attributes = [
        'status' => SequenceStatus::Draft,
    ];

    public function newEloquentBuilder($query): SequenceBuilder
    {
        return new SequenceBuilder($query);
    }

    public function mails(): HasMany
    {
        return $this->hasMany(SequenceMail::class);
    }

    public function sent_mails(): HasManyThrough
    {
        return $this->hasManyThrough(SentMail::class, SequenceMail::class, 'id', 'sendable_id');
    }

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(Subscriber::class)->withPivot('subscribed_at');
    }
}
