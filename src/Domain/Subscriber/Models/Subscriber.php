<?php

namespace Domain\Subscriber\Models;

use Domain\Broadcast\Models\Broadcast;
use Domain\Shared\Models\BaseModel;
use Domain\Subscriber\Builders\SubscriberBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;
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
        return $this->belongsTo(Form::class);
    }

    public function newEloquentBuilder($query): SubscriberBuilder
    {
        return new SubscriberBuilder($query);
    }
}
