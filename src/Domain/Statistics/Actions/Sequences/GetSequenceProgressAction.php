<?php

namespace Domain\Statistics\Actions\Sequences;

use Domain\Sequence\Models\Sequence;
use Domain\Sequence\Models\SequenceMail;
use Domain\Statistics\DataTransferObjects\SequenceProgress\SequenceProgressData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GetSequenceProgressAction
{
    public static function execute(Sequence $sequence)
    {
        $sentMailStats = self::sentMailStats($sequence);

        return new SequenceProgressData(
            total: $sentMailStats->count(),
            in_progress: $sentMailStats->filter(fn (object $sentMailStat) => $sentMailStat->status === 'in-progress')->count(),
            completed: $sentMailStats->filter(fn (object $sentMailStat) => $sentMailStat->status === 'completed')->count(),
        );
    }

    public static function sentMailStats(Sequence $sequence): Collection
    {
        return DB::table('sent_mails')
            ->select(DB::raw('subscriber_id, count(*) count'))
            ->whereIn('mailable_id', $sequence->mails()->pluck('id'))
            ->whereMailableType(SequenceMail::class)
            ->groupBy('subscriber_id')
            ->get()
            ->map(function (object $sentMailStat) use ($sequence) {
                $sentMailStat->status = $sentMailStat->count === $sequence->mails()->count()
                    ? 'completed'
                    : 'in-progress';

                return $sentMailStat;
            });
    }
}
