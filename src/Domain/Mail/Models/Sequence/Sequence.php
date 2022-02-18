<?php

namespace Domain\Mail\Models\Sequence;

use Domain\Mail\Enums\Sequence\SequenceStatus;
use Domain\Mail\Models\Concerns\HasPerformance;
use Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sequence extends BaseModel
{
    use HasPerformance;

    protected $fillable = [
        'title',
        'status',
    ];

    protected $casts = [
        'status' => SequenceStatus::class,
    ];

    protected $attributes = [
        'status' => SequenceStatus::Draft,
    ];

    public function mails(): HasMany
    {
        return $this->hasMany(SequenceMail::class);
    }
}
