<?php

namespace Domain\Mail\Models\Sequence;

use Domain\Mail\Builders\Sequence\SequenceBuilder;
use Domain\Mail\DataTransferObjects\PerformanceData;
use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\Enums\Sequence\SequenceStatus;
use Domain\Mail\Models\Concerns\HasPerformance;
use Domain\Mail\Models\SentMail;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\LaravelData\WithData;

class Sequence extends BaseModel
{
    use WithData;
    use HasUser;
    use HasPerformance;

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
        return $this->hasManyThrough(
            SentMail::class,
            SequenceMail::class,
            'sequence_id',
            'sendable_id'
        )->where('sent_mails.sendable_type', SequenceMail::class);
    }

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(Subscriber::class)->withPivot(['subscribed_at', 'status']);
    }

    // -------- HasPerformance --------

    public function performance(): PerformanceData
    {
        $total = $this->activeSubscriberCount();

        return new PerformanceData(
            total: $total,
            open_rate: $this->openRate($total),
            click_rate: $this->clickRate($total),
        );
    }
}
