<?php

namespace Domain\Mail\Contracts;

use Illuminate\Support\Collection;

interface Sendable
{
    public function id(): int;
    public function subject(): string;
    public function content(): string;
    public function type(): string;
    public function filters(): Collection;
}
