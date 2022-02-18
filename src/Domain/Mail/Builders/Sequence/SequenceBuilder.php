<?php

namespace Domain\Mail\Builders\Sequence;

use Domain\Mail\Enums\Sequence\SequenceMailStatus;
use Domain\Mail\Models\SentMail;
use Illuminate\Database\Eloquent\Builder;

class SequenceBuilder extends Builder
{
    public function getSubscriberCount()
    {
        return SentMail::whereSequence($this->model)
            ->distinct('subscriber_id')
            ->count();
    }
}
