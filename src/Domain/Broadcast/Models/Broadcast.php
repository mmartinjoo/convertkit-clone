<?php

namespace Domain\Broadcast\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Broadcast extends Model
{
    use HasFactory;

    public function filters(): HasMany
    {
        return $this->hasMany(BroadcastFilter::class);
    }
}
