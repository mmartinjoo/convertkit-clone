<?php

namespace Domain\Statistics\ViewModels\Tracking;

use Domain\Mail\Actions\GetPerformanceAction;
use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\Models\SentMail;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Shared\ViewModels\ViewModel;
use Domain\Statistics\DataTransferObjects\SequenceProgress\SequenceProgressData;
use Domain\Statistics\DataTransferObjects\Tracking\TrackingData;
use Domain\Statistics\ValueObjects\Percent;
use Illuminate\Database\Eloquent\Builder;
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

    public function totalPerformance(): TrackingData
    {
        $total = $this->sentMails($this->sequence)->count();

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

    /*
     * @return Collection<int, TrackingData>
     */
    public function mailPerformances(): Collection
    {
        return $this->sequence->mails->mapWithKeys(fn (SequenceMail $mail) =>
            [$mail->id => GetPerformanceAction::execute($mail)]
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

    private function averageOpenRate(int $total): Percent
    {
        return Percent::from(
            $this->sentMails()
                ->whereOpened()
                ->count() / $total
        );
    }

    private function averageClickRate(int $total): Percent
    {
        return Percent::from(
            $this->sentMails()
                ->whereClicked()
                ->count() / $total
        );
    }

    private function sentMails(): Builder
    {
        return SentMail::query()
            ->whereIn('mailable_id', $this->sequence->mails()->pluck('id'))
            ->whereMailableType("Domain\\Sequence\\Models\\SequenceMail");
    }
}
