<?php

namespace Domain\Shared\Models\Concerns;

use Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasUser
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
