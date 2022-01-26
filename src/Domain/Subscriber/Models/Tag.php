<?php

namespace Domain\Subscriber\Models;

use Domain\Subscriber\Builders\TagBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class);
    }

    public function newEloquentBuilder($query): TagBuilder
    {
        return new TagBuilder($query);
    }
}
