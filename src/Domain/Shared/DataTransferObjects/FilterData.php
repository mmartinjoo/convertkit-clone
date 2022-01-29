<?php

namespace Domain\Shared\DataTransferObjects;

use Spatie\LaravelData\Data;

class FilterData extends Data
{
    public function __construct(
        public readonly string $type,
        public readonly array $value,
    ) {}
}
