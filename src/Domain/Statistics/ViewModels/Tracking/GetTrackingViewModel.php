<?php

namespace Domain\Statistics\ViewModels\Tracking;

use Domain\Shared\Models\Concerns\Sendable;
use Domain\Mail\Models\SentMail;
use Domain\Shared\ViewModels\ViewModel;
use Domain\Statistics\DataTransferObjects\Tracking\TrackingData;
use Domain\Statistics\ValueObjects\Percent;
use Illuminate\Database\Eloquent\Builder;

class GetTrackingViewModel extends ViewModel
{
    public function __construct(private readonly Sendable $sendable)
    {
    }

    public function __invoke(): TrackingData
    {
        $total = $this->sentMail($this->sendable)->count();

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

    private function averageOpenRate(int $total): Percent
    {
        return Percent::from(
            $this->sentMail()
                ->whereOpened()
                ->count() / $total
        );
    }

    private function averageClickRate(int $total): Percent
    {
        return Percent::from(
            $this->sentMail()
                ->whereClicked()
                ->count() / $total
        );
    }

    private function sentMail(): Builder
    {
        return SentMail::query()
            ->where('mailable_id', $this->sendable->id())
            ->where('mailable_type', $this->sendable->type());
    }
}
