<?php

namespace Domain\Subscriber\Models;

use Domain\Broadcast\Models\Broadcast;
use Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;

class Subscriber extends BaseModel
{
    use Notifiable;

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function broadcasts(): BelongsToMany
    {
        return $this->belongsToMany(Broadcast::class);
    }
}
