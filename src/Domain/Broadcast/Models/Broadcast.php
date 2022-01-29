<?php

namespace Domain\Broadcast\Models;

use Domain\Shared\Models\Casts\FiltersCast;
use Domain\Broadcast\Enums\BroadcastStatus;
use Domain\Shared\DataTransferObjects\FilterData;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasSubscriberFilters;
use Domain\Shared\Models\SentMail;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

class Broadcast extends BaseModel implements HasSubscriberFilters
{
    protected $fillable = [
        'id',
        'title',
        'content',
        'status',
        'filters',
        'sent_at',
    ];

    protected $casts = [
        'filters' => FiltersCast::class,
        'status' => BroadcastStatus::class,
    ];

    protected $attributes = [
        'status' => BroadcastStatus::DRAFT,
    ];

    public function sent_mails(): MorphMany
    {
        return $this->morphMany(SentMail::class, 'mailable');
    }

    /**
     * @return Collection<FilterData>
     */
    public function filters(): Collection
    {
        return $this->filters;
    }
}
