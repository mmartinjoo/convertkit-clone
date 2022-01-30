<?php

namespace Domain\Statistics\Actions;

use Domain\Statistics\DataTransferObjects\DailyNewSubscribers\DailyData;
use Domain\Statistics\DataTransferObjects\DailyNewSubscribers\DailySummaryData;
use Illuminate\Support\Facades\DB;

class GetDailyNewSubscribersCountAction
{
    public static function execute(): DailySummaryData
    {
        $daily = self::daily();
        return DailySummaryData::from([
            'total' => collect($daily)->sum(fn (DailyData $data) => $data->count),
            'daily' => $daily,
        ]);
    }

    /**
     * @return array<int, DailyData>
     */
    private static function daily(): array
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
