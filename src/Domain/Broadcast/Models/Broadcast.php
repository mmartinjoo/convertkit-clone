<?php

namespace Domain\Broadcast\Models;

use Domain\Shared\Models\Casts\FiltersCast;
use Domain\Broadcast\Enums\BroadcastStatus;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\SentMail;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Broadcast extends BaseModel
{
    protected $fillable = [
        'id',
        'title',
        'content',
        'status',
        'filters',
        'sent_at',
    ];

    protected $casts = [
        'filters' => FiltersCast::class,
        'status' => BroadcastStatus::class,
    ];

    protected $attributes = [
        'status' => BroadcastStatus::DRAFT,
    ];

    public function sent_mails(): MorphMany
    {
        return $this->morphMany(SentMail::class, 'mailable');
    }
}
