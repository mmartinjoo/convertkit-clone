<?php

namespace Domain\Mail\Models\Sequence;

use Domain\Mail\Builders\Sequence\SequenceMailBuilder;
use Domain\Mail\Enums\Sequence\SequenceMailStatus;
use Domain\Shared\DataTransferObjects\FilterData;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Casts\FiltersCast;
use Domain\Shared\Models\Concerns\HasSubscriberFilters;
use Domain\Shared\Models\Concerns\Sendable;
use Domain\Mail\Models\SentMail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

class SequenceMail extends BaseModel implements HasSubscriberFilters, Sendable
{
    protected $fillable = [
        'sequence_id',
        'sequence_mail_schedule_id',
        'title',
        'content',
        'status',
        'filters',
        'status',
    ];

    protected $casts = [
        'status' => SequenceMailStatus::class,
        'filters' => FiltersCast::class,
    ];

    protected $attributes = [
        'status' => SequenceMailStatus::DRAFT,
    ];

    public function sequence(): BelongsTo
    {
        return $this->belongsTo(Sequence::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(SequenceMailSchedule::class, 'sequence_mail_schedule_id');
    }

    public function sent_mails(): MorphMany
    {
        return $this->morphMany(SentMail::class, 'mailable');
    }

    public function newEloquentBuilder($query): SequenceMailBuilder
    {
        return new SequenceMailBuilder($query);
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

    public function title(): string
    {
        return $this->title;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function type(): string
    {
        return $this::class;
    }

    public function shouldSendToday(): bool
    {
        return collect($this->schedule->days)
            ->contains(now()->dayOfWeek);
    }

    public function enoughTimePassedSince(SentMail $mail): bool
    {
        return $this->schedule->unit->timePassed($mail->sent_at) >= $this->schedule->delay;
    }
}
