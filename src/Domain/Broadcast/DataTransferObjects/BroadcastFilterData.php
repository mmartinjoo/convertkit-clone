<?php

namespace Domain\Broadcast\DataTransferObjects;

use Spatie\LaravelData\Data;

class BroadcastFilterData extends Data
{
    public function __construct(
        public readonly string $type,
        public readonly array $value,
    ) {}
}
