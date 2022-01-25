<?php

namespace App\Models;

use App\Builders\TagBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
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
