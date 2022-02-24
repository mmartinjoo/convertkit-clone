<?php

namespace Domain\Subscriber\Models;

use Domain\Shared\Models\BaseModel;
use Domain\Subscriber\DataTransferObjects\FormData;
use Spatie\LaravelData\WithData;

class Form extends BaseModel
{
    use WithData;

    protected $fillable = [
        'title',
        'content',
    ];

    protected $attributes = [
        'title' => '-',
        'content' => '',
    ];

    protected $dataClass = FormData::class;
}
