<?php

namespace Domain\Shared\DataTransferObject;

use Spatie\LaravelData\Data;

class PaginationData extends Data
{
    public function __construct(
        public readonly int $total,
        public readonly int $current_page,
    ) {}
}
