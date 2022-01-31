<?php

namespace Domain\Statistics\ViewModels;

use Domain\Shared\ViewModels\ViewModel;
use Domain\Statistics\DataTransferObjects\DailyNewSubscribers\DailyData;
use Domain\Statistics\DataTransferObjects\DailyNewSubscribers\DailySummaryData;
use Illuminate\Support\Facades\DB;

class GetDailySubscribersViewModel extends ViewModel
{
    public function __invoke(): DailySummaryData
    {
        $daily = $this->daily();
        return DailySummaryData::from([
            'total' => collect($daily)->sum(fn (DailyData $data) => $data->count),
            'daily' => $daily,
        ]);
    }

    /**
     * @return array<int, DailyData>
     */
    private function daily(): array
    {
        return DB::table('subscribers')
            ->select(DB::raw("count(*) count, date_format(created_at, '%Y-%m-%d') day"))
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->map(fn (object $data) => DailyData::from((array) $data))
            ->all();
    }
}
