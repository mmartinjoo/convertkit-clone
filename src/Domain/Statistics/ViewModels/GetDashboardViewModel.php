<?php

namespace Domain\Statistics\ViewModels;

use Domain\Mail\Models\SentMail;
use Domain\Shared\ViewModels\ViewModel;
use Domain\Statistics\DataTransferObjects\DailyNewSubscribers\DailyData;
use Domain\Statistics\DataTransferObjects\NewSubscribersCountData;
use Domain\Statistics\DataTransferObjects\Tracking\TrackingData;
use Domain\Statistics\Filters\DateFilter;
use Domain\Statistics\ValueObjects\Percent;
use Domain\Subscriber\DataTransferObjects\SubscriberData;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GetDashboardViewModel extends ViewModel
{
    public function newSubscribersCount(): NewSubscribersCountData
    {
        return new NewSubscribersCountData(
            total: Subscriber::count(),
            this_week: Subscriber::whereSubscribedBetween(DateFilter::thisWeek())->count(),
            this_month: Subscriber::whereSubscribedBetween(DateFilter::thisMonth())->count(),
            today: Subscriber::whereSubscribedBetween(DateFilter::today())->count(),
        );
    }

    /**
     * @return Collection<DailyData>
     */
    public function dailySubscribers(): Collection
    {
        return DB::table('subscribers')
            ->select(DB::raw("count(*) count, date_format(created_at, '%Y-%m-%d') day"))
            ->groupBy('day')
            ->orderByDesc('day')
            ->get()
            ->map(fn (object $data) => DailyData::from((array) $data));
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

    /**
     * @return Collection<SubscriberData>
     */
    public function recentSubscribers(): Collection
    {
        return Subscriber::with('form')->latest()->take(10)->get();
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
