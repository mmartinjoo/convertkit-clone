<?php

namespace Domain\Shared\Models\Concerns;

interface Sendable
{
    public function id(): int;
    public function title(): string;
    public function content(): string;
    public function type(): string;
}
