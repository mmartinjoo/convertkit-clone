<?php

namespace Domain\Mail\Models\Sequence;

use Domain\Mail\Builders\Sequence\SequenceBuilder;
use Domain\Mail\Enums\Sequence\SequenceStatus;
use Domain\Mail\Models\SentMail;
use Domain\Shared\Models\BaseModel;
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

    public function mails(): HasMany
    {
        return $this->hasMany(SequenceMail::class);
    }

    public function sent_mails(): HasManyThrough
    {
        return $this->hasManyThrough(SentMail::class, SequenceMail::class, 'id', 'mailable_id');
    }

    public function newEloquentBuilder($query): SequenceBuilder
    {
        return new SequenceBuilder($query);
    }
}
