<?php

namespace Domain\Mail\Models\Broadcast;

use Domain\Shared\Models\Casts\FiltersCast;
use Domain\Mail\Enums\Broadcast\BroadcastStatus;
use Domain\Shared\DataTransferObjects\FilterData;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasSubscriberFilters;
use Domain\Shared\Models\Concerns\Sendable;
use Domain\Mail\Models\SentMail;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

class Broadcast extends BaseModel implements HasSubscriberFilters, Sendable
{
    protected $fillable = [
        'id',
        'subject',
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

    public function id(): int
    {
        return $this->id;
    }

    public function subject(): string
    {
        return $this->subject;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function type(): string
    {
        return $this::class;
    }
}
