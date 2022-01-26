<?php

namespace Domain\Broadcast\Models;

use Domain\Subscriber\Models\Subscriber;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Broadcast extends Model
{
    use HasFactory;

    public function filters(): HasMany
    {
        return $this->hasMany(BroadcastFilter::class);
    }

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(Subscriber::class);
    }
}
