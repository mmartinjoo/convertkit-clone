<?php

namespace Domain\Statistics\ViewModels;

use Domain\Sequence\Models\Sequence;
use Domain\Shared\ViewModels\ViewModel;
use Domain\Statistics\DataTransferObjects\SequenceProgress\SequenceProgressData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GetSequenceProgressViewModel extends ViewModel
{
    public function __construct(private readonly Sequence $sequence)
    {
    }

    public function __invoke(): SequenceProgressData
    {
        $sentMailStats = $this->sentMailStats();

        return new SequenceProgressData(
            total: $sentMailStats->count(),
            in_progress: $sentMailStats->filter(fn (object $sentMailStat) => $sentMailStat->status === 'in-progress')->count(),
            completed: $sentMailStats->filter(fn (object $sentMailStat) => $sentMailStat->status === 'completed')->count(),
        );
    }

    private function sentMailStats(): Collection
    {
        return DB::table('sent_mails')
            ->select(DB::raw('subscriber_id, count(*) count'))
            ->whereIn('mailable_id', $this->sequence->mails()->pluck('id'))
            ->whereMailableType("Domain\\Sequence\\Models\\SequenceMail")
            ->groupBy('subscriber_id')
            ->get()
            ->map(function (object $sentMailStat) {
                $sentMailStat->status = $sentMailStat->count === $this->sequence->mails()->count()
                    ? 'completed'
                    : 'in-progress';

                return $sentMailStat;
            });
    }
}
