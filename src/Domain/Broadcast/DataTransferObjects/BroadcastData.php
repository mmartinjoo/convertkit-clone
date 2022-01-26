<?php

namespace Domain\Broadcast\DataTransferObjects;

use Spatie\LaravelData\Data;

class BroadcastData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $title,
        public readonly string $content,
        public readonly string $status,
    ) {}
}
