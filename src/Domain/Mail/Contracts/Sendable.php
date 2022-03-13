<?php

namespace Domain\Mail\Contracts;

use Illuminate\Database\Eloquent\Relations\Relation;

interface Sendable
{
    public function id(): int;
    public function subject(): string;
    public function content(): string;
    public function type(): string;
    public function sent_mails(): Relation;
}
