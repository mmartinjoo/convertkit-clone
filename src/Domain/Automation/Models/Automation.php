<?php

namespace Domain\Automation\Models;

use Domain\Automation\DataTransferObjects\AutomationData;
use Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\LaravelData\WithData;

class Automation extends BaseModel
{
    use WithData;

    protected $fillable = [
        'name',
    ];

    protected $dataClass = AutomationData::class;

    public function steps(): HasMany
    {
        return $this->hasMany(AutomationStep::class);
    }
}
