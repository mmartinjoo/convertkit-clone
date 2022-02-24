<?php

namespace Domain\Subscriber\Models;

use Domain\Shared\Models\BaseModel;
use Domain\Subscriber\DataTransferObjects\TagData;
use Spatie\LaravelData\WithData;

class Tag extends BaseModel
{
    use WithData;

    protected $fillable = [
        'title',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    protected $dataClass = TagData::class;

    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class);
    }
}
