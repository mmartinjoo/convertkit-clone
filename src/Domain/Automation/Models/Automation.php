<?php

namespace Domain\Automation\Models;

use Domain\Automation\DataTransferObjects\AutomationData;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\LaravelData\WithData;

class Automation extends BaseModel
{
    use WithData;
    use HasUser;

    protected $dataClass = AutomationData::class;

    protected $fillable = [
        'name',
        'user_id',
    ];

    public function steps(): HasMany
    {
        return $this->hasMany(AutomationStep::class);
    }
}
