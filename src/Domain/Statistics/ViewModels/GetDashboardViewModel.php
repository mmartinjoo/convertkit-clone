<?php

namespace Domain\Statistics\ViewModels;

use Domain\Mail\Models\SentMail;
use Domain\Shared\ViewModels\ViewModel;
use Domain\Statistics\DataTransferObjects\NewSubscribersCountData;
use Domain\Statistics\DataTransferObjects\Tracking\TrackingData;
use Domain\Statistics\Filters\DateFilter;
use Domain\Statistics\ValueObjects\Percent;
use Domain\Subscriber\Models\Subscriber;

class GetDashboardViewModel extends ViewModel
{
    public function newSubscribersCount(): NewSubscribersCountData
    {
        return new NewSubscribersCountData(
            total: Subscriber::count(),
            thisWeek: Subscriber::whereSubscribedBetween(DateFilter::thisWeek())->count(),
            thisMonth: Subscriber::whereSubscribedBetween(DateFilter::thisMonth())->count(),
            today: Subscriber::whereSubscribedBetween(DateFilter::today())->count(),
        );
    }

    public function tracking(): TrackingData
    {
        $total = SentMail::count();

        return new TrackingData(
            total_sent_mails: $total,
            average_open_rate: $this->averageOpenRate($total),
            average_click_rate: $this->averageClickRate($total),
        );
    }

    private function averageOpenRate(int $total): Percent
    {
        return Percent::from(
            SentMail::whereOpened()->count() / $total
        );
    }

    private function averageClickRate(int $total): Percent
    {
        return Percent::from(
            SentMail::whereClicked()->count() / $total
        );
    }
}
