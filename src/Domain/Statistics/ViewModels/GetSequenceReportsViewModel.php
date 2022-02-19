<?php

namespace Domain\Statistics\ViewModels;

use Domain\Mail\Actions\GetPerformanceAction;
use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Shared\ViewModels\ViewModel;
use Domain\Statistics\DataTransferObjects\SequenceProgressData;
use Domain\Statistics\DataTransferObjects\PerformanceData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GetSequenceReportsViewModel extends ViewModel
{
    public function __construct(private readonly Sequence $sequence)
    {
    }

    public function sequence(): SequenceData
    {
        return SequenceData::from($this->sequence);
    }

    public function totalPerformance(): PerformanceData
    {
        return GetPerformanceAction::execute($this->sequence);
    }

    /*
     * @return Collection<int, TrackingData>
     */
    public function mailPerformances(): Collection
    {
        return $this->sequence->mails->mapWithKeys(fn (SequenceMail $mail) =>
            [$mail->id => GetPerformanceAction::execute($mail)],
        );
    }

    public function progress(): SequenceProgressData
    {
        $sentMailStats = $this->sentMailProgress();

        return new SequenceProgressData(
            total: $sentMailStats->count(),
            in_progress: $sentMailStats->filter(fn (object $sentMailStat) => $sentMailStat->status === 'in-progress')->count(),
            completed: $sentMailStats->filter(fn (object $sentMailStat) => $sentMailStat->status === 'completed')->count(),
        );
    }

    private function sentMailProgress(): Collection
    {
        return DB::table('sent_mails')
            ->select(DB::raw('subscriber_id, count(*) count'))
            ->whereIn('mailable_id', $this->sequence->mails()->pluck('id'))
            ->whereMailableType(SequenceMail::class)
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
