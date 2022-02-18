<?php

namespace Domain\Mail\Models\Concerns;

use Domain\Mail\Contracts\Sendable;
use Domain\Mail\Models\SentMail;
use Domain\Statistics\DataTransferObjects\Tracking\TrackingData;
use Domain\Statistics\ValueObjects\Percent;
use Illuminate\Database\Eloquent\Builder;
use RuntimeException;

trait HasPerformance
{
    public static function bootHasPerformance()
    {
        if (! (new self() instanceof Sendable)) {
            throw new RuntimeException('HasPerformance can only be used in Sendable instances');
        }
    }

    public function getPerformance(): TrackingData
    {
        $total = $this->sentMail()->count();

        if ($total === 0) {
            return new TrackingData(
                total_sent_mails: 0,
                average_open_rate: Percent::from(0),
                average_click_rate: Percent::from(0),
            );
        }

        return new TrackingData(
            total_sent_mails: $total,
            average_open_rate: $this->averageOpenRate($total),
            average_click_rate: $this->averageClickRate($total),
        );
    }

    protected function averageOpenRate(int $total): Percent
    {
        return Percent::from(
            $this->sentMail()
                ->whereOpened()
                ->count() / $total
        );
    }

    protected function averageClickRate(int $total): Percent
    {
        return Percent::from(
            $this->sentMail()
                ->whereClicked()
                ->count() / $total
        );
    }

    protected function sentMail(): Builder
    {
        return SentMail::query()
            ->where('mailable_id', $this->id())
            ->where('mailable_type', $this->type());
    }
}
