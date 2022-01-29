<?php

namespace Domain\Sequence\Models;

use Domain\Sequence\Enums\SequenceStatus;
use Domain\Shared\Models\BaseModel;

class Sequence extends BaseModel
{
    protected $fillable = [
        'title',
        'status',
    ];

    protected $casts = [
        'status' => SequenceStatus::class,
    ];

    protected $attributes = [
        'status' => SequenceStatus::DRAFT,
    ];
}
