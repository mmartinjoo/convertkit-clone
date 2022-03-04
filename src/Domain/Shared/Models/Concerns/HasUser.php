<?php

namespace Domain\Shared\Models\Concerns;

use Domain\Shared\Models\Scopes\UserScope;
use Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasUser
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new UserScope());
    }
}
