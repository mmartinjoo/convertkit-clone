<?php

namespace Domain\Subscriber\Models;

use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Shared\Models\BaseModel;
use Domain\Mail\Models\SentMail;
use Domain\Subscriber\Builders\SubscriberBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class Subscriber extends BaseModel
{
    use Notifiable;

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'form_id'
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function newEloquentBuilder($query): SubscriberBuilder
    {
        return new SubscriberBuilder($query);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function broadcasts(): BelongsToMany
    {
        return $this->belongsToMany(Broadcast::class);
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class)
            ->withDefault(fn () => new Form([
                'title' => '-',
                'content' => '',
            ]));
    }

    public function received_mails(): HasMany
    {
        return $this->hasMany(SentMail::class);
    }

    public function last_received_mail(): HasOne
    {
        return $this->hasOne(SentMail::class)
            ->latestOfMany()
            ->withDefault();
    }

    public function tooEarlyFor(SequenceMail $mail): bool
    {
        return !$mail->enoughTimePassedSince($this->last_received_mail);
    }
}
