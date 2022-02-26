<?php

namespace Domain\Subscriber\Models;

use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Domain\Subscriber\DataTransferObjects\TagData;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\LaravelData\WithData;

class Tag extends BaseModel
{
    use WithData;
    use HasUser;

    protected $dataClass = TagData::class;

    protected $fillable = [
        'title',
        'user_id',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(Subscriber::class);
    }
}
