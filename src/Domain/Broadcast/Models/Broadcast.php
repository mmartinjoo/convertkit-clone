<?php

namespace Domain\Broadcast\Models;

use Domain\Broadcast\Enums\BroadcastStatus;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Broadcast extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'content',
        'status',
        'filters',
        'sent_at',
    ];

    protected $casts = [
        'filters' => 'json',
        'status' => BroadcastStatus::class,
    ];

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(Subscriber::class);
    }
}
