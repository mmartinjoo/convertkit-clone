<?php

namespace Domain\Automation\Models;

use Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Automation extends BaseModel
{
    protected $fillable = ['name'];

    public function steps(): HasMany
    {
        return $this->hasMany(AutomationStep::class);
    }
}
