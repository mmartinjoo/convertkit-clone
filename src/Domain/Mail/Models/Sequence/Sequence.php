<?php

namespace Domain\Mail\Models\Sequence;

use Domain\Mail\Builders\Sequence\SequenceBuilder;
use Domain\Mail\Contracts\Measurable;
use Domain\Mail\DataTransferObjects\PerformanceData;
use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\Enums\Sequence\SequenceStatus;
use Domain\Mail\Models\SentMail;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\LaravelData\WithData;

class Sequence extends BaseModel implements Measurable
{
    use WithData;
    use HasUser;

    protected $fillable = [
        'title',
        'status',
        'user_id',
    ];

    protected $casts = [
        'status' => SequenceStatus::class,
    ];

    protected $attributes = [
        'status' => SequenceStatus::Draft,
    ];

    protected $dataClass = SequenceData::class;

    public function newEloquentBuilder($query): SequenceBuilder
    {
        return new SequenceBuilder($query);
    }

    public function mails(): HasMany
    {
        return $this->hasMany(SequenceMail::class);
    }

    public function sent_mails(): HasManyThrough
    {
        return $this->hasManyThrough(SentMail::class, SequenceMail::class, 'id', 'sendable_id');
    }

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(Subscriber::class)->withPivot('subscribed_at');
    }

    // -------- Measurable --------

    public function sentMailsQuery(): Builder
    {
        return SentMail::whereSequence($this);
    }

    public function performance(): PerformanceData
    {
        $total = $this->activeSubscriberCount();

        return new PerformanceData(
            total: $total,
            open_rate: SentMail::getOpenRate($this, $total),
            click_rate: SentMail::getClickRate($this, $total),
        );
    }
}
