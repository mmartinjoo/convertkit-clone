<?php

namespace Domain\Mail\Models\Sequence;

use Domain\Mail\Builders\Sequence\SequenceMailBuilder;
use Domain\Mail\DataTransferObjects\PerformanceData;
use Domain\Mail\Enums\Sequence\SequenceMailStatus;
use Domain\Mail\DataTransferObjects\FilterData;
use Domain\Mail\Models\Concerns\HasPerformance;
use Domain\Shared\Models\BaseModel;
use Domain\Mail\Models\Casts\FiltersCast;
use Domain\Mail\Contracts\Sendable;
use Domain\Mail\Models\SentMail;
use Domain\Shared\Models\Concerns\HasUser;
use Domain\Subscriber\Models\Concerns\HasAudience;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class SequenceMail extends BaseModel implements Sendable
{
    use HasAudience;
    use HasPerformance;
    use HasUser;

    protected $fillable = [
        'sequence_id',
        'sequence_mail_schedule_id',
        'subject',
        'content',
        'status',
        'filters',
        'status',
        'user_id',
    ];

    protected $casts = [
        'status' => SequenceMailStatus::class,
        'filters' => FiltersCast::class,
    ];

    protected $attributes = [
        'status' => SequenceMailStatus::Draft,
    ];

    public function sequence(): BelongsTo
    {
        return $this->belongsTo(Sequence::class);
    }

    public function schedule(): HasOne
    {
        return $this->hasOne(SequenceMailSchedule::class);
    }

    public function sent_mails(): MorphMany
    {
        return $this->morphMany(SentMail::class, 'sendable');
    }

    public function newEloquentBuilder($query): SequenceMailBuilder
    {
        return new SequenceMailBuilder($query);
    }

    public function shouldSendToday(): bool
    {
        $dayName = Str::lower(now()->dayName);
        return $this->schedule->allowed_days->{$dayName};
    }

    public function enoughTimePassedSince(SentMail $mail): bool
    {
        return $this->schedule->unit->timePassedSince($mail->sent_at) >= $this->schedule->delay;
    }

    // -------- Sendable --------

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

    // -------- HasAudience --------

    public function filters(): FilterData
    {
        return $this->filters;
    }

    protected function audienceQuery(): Builder
    {
        return Subscriber::whereIn('id', $this->sequence->subscribers()->select('subscribers.id')->pluck('id'));
    }

    // -------- HasPerformance --------

    public function performance(): PerformanceData
    {
        $total = SentMail::countOf($this);

        return new PerformanceData(
            total: $total,
            open_rate: $this->openRate($total),
            click_rate: $this->clickRate($total),
        );
    }
}
