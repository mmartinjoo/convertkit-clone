<?php

namespace Domain\Mail\Builders\SentMail;

use Illuminate\Database\Eloquent\Builder;

class SentMailBuilder extends Builder
{
    public function whereOpened(): self
    {
        return $this->whereNotNull('opened_at');
    }

    public function whereClicked(): self
    {
        return $this->whereNotNull('clicked_at');
    }
}