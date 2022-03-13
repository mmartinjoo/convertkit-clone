<?php

namespace Domain\Shared\ViewModels;

use Domain\Mail\Models\SentMail;
use Domain\Shared\Models\User;
use Domain\Subscriber\DataTransferObjects\DailySubscribersData;
use Domain\Subscriber\DataTransferObjects\NewSubscribersCountData;
use Domain\Mail\DataTransferObjects\PerformanceData;
use Domain\Shared\Filters\DateFilter;
use Domain\Shared\ValueObjects\Percent;
use Domain\Subscriber\DataTransferObjects\SubscriberData;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GetDashboardViewModel extends ViewModel
{
    public function __construct(private readonly User $user)
    {
    }

    public function newSubscribersCount(): NewSubscribersCountData
    {
        return new NewSubscribersCountData(
            total: Subscriber::count(),
            this_month: Subscriber::whereSubscribedBetween(DateFilter::thisMonth())->count(),
            this_week: Subscriber::whereSubscribedBetween(DateFilter::thisWeek())->count(),
            today: Subscriber::whereSubscribedBetween(DateFilter::today())->count(),
        );
    }

    /**
     * @return Collection<DailySubscribersData>
     */
    public function dailySubscribers(): Collection
    {
        return DB::table('subscribers')
            ->select(DB::raw("count(*) count, date_format(subscribed_at, '%Y-%m-%d') day"))
            ->groupBy('day')
            ->orderByDesc('day')
            ->whereUserId($this->user->id)
            ->get()
            ->map(fn (object $data) => DailySubscribersData::from((array) $data));
    }

    public function performance(): PerformanceData
    {
        $total = SentMail::count();

        return new PerformanceData(
            total: $total,
            open_rate: $this->averageOpenRate($total),
            click_rate: $this->averageClickRate($total),
        );
    }

    /**
     * @return Collection<SubscriberData>
     */
    public function recentSubscribers(): Collection
    {
        return Subscriber::with(['form', 'tags'])
            ->orderByDesc('subscribed_at')
            ->take(10)
            ->get()
            ->map
            ->getData();
    }

    private function averageOpenRate(int $total): Percent
    {
        return Percent::from(
            SentMail::whereOpened()->count(), $total
        );
    }

    private function averageClickRate(int $total): Percent
    {
        return Percent::from(
            SentMail::whereClicked()->count(), $total
        );
    }
}
