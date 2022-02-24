<?php

namespace Domain\Mail\Builders\Sequence;

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
            ->whereStatus('in-progress')
            ->count();
    }

    public function completedSubscriberCount(): int
    {
        return $this->model
            ->subscribers()
            ->whereStatus('completed')
            ->count();
    }
}
