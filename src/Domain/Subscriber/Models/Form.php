<?php

namespace Domain\Subscriber\Models;

use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Domain\Subscriber\DataTransferObjects\FormData;
use Spatie\LaravelData\WithData;

class Form extends BaseModel
{
    use WithData;
    use HasUser;

    protected $dataClass = FormData::class;

    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];

    protected $attributes = [
        'title' => '-',
        'content' => '',
    ];
}
