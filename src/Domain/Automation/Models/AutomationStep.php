<?php

namespace Domain\Automation\Models;

use Domain\Automation\Enums\AutomationStepType;
use Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AutomationStep extends BaseModel
{
    protected $fillable = [
        'name',
        'type',
        'value',
        'automation_id',
    ];

    protected $casts = [
        'value' => 'array',
        'type' => AutomationStepType::class,
    ];

    public function automation(): BelongsTo
    {
        return $this->belongsTo(Automation::class);
    }
}
