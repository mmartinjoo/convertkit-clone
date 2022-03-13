<?php

namespace Domain\Mail\Models\Concerns;

use Domain\Mail\DataTransferObjects\PerformanceData;
use Domain\Shared\ValueObjects\Percent;
use Illuminate\Database\Eloquent\Relations\Relation;

trait HasPerformance
{
    abstract public function performance(): PerformanceData;
    abstract public function sent_mails(): Relation;

    public function openRate(int $total): Percent
    {
        return Percent::from(
            $this->sent_mails()->whereOpened()->count(), $total
        );
    }

    public function clickRate(int $total): Percent
    {
        return Percent::from(
            $this->sent_mails()->whereClicked()->count(), $total
        );
    }
}
