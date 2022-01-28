<?php

namespace Domain\Subscriber\Models;

use Domain\Shared\Models\BaseModel;

class Tag extends BaseModel
{
    protected $fillable = [
        'title',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class);
    }
}
