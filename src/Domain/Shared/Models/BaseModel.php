<?php

namespace Domain\Shared\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class BaseModel extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        $modelName = Str::of(get_called_class())->explode("\\")->last();
        return app("Database\\Factories\\${modelName}Factory");
    }
}
