<?php

namespace Domain\Subscriber\Models;

use Domain\Broadcast\Models\Broadcast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;

class Subscriber extends Model
{
    use HasFactory;
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
