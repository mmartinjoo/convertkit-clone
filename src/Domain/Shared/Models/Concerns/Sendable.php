<?php

namespace Domain\Shared\Models\Concerns;

interface Sendable
{
    public function title(): string;
    public function content(): string;
}
