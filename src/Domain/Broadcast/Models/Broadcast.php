<?php

namespace Domain\Broadcast\Models;

use Domain\Shared\Models\Casts\FiltersCast;
use Domain\Broadcast\Enums\BroadcastStatus;
use Domain\Shared\Models\BaseModel;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(Subscriber::class);
    }
}
