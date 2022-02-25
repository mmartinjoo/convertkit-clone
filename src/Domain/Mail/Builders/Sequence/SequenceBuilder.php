<?php

namespace Domain\Mail\Builders\Sequence;

use Domain\Mail\Enums\Sequence\SubscriberStatus;
use Illuminate\Database\Eloquent\Builder;

class SequenceBuilder extends Builder
{
    public function activeSubscriberCount(): int
    {
        return $this->model
            ->subscribers()
            ->whereNotNull('status')
            ->count();
    }

    public function inProgressSubscriberCount(): int
    {
        return $this->model
            ->subscribers()
            ->whereStatus(SubscriberStatus::InProgress)
            ->count();
    }

    public function completedSubscriberCount(): int
    {
        return $this->model
            ->subscribers()
            ->whereStatus(SubscriberStatus::Completed)
            ->count();
    }
}
