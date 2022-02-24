<?php

namespace Domain\Mail\ViewModels\Sequence;

use Domain\Mail\Actions\GetPerformanceAction;
use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\Models\SentMail;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Shared\ViewModels\ViewModel;
use Domain\Mail\DataTransferObjects\Sequence\SequenceProgressData;
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
        $progresses = $this->sequenceProgresses();

        return new SequenceProgressData(
            total: $this->sequence->subscribers()->count(),
            in_progress: $progresses->filter(fn (string $progress) => $progress === 'in-progress')->count(),
            completed: $progresses->filter(fn (string $progress) => $progress === 'completed')->count(),
        );
    }

    /**
     * @return Collection<string>
     */
    private function sequenceProgresses(): Collection
    {
        $sequenceMailCount = $this->sequence->mails()->count();

        return SentMail::select(['subscriber_id', DB::raw('count(sent_mails.id) sent_mail_count')])
            ->whereIn('mailable_id', $this->sequence->mails()->pluck('id'))
            ->where('mailable_type', SequenceMail::class)
            ->groupBy('subscriber_id')
            ->get()
            ->map(fn (SentMail $mail) =>
                $mail->sent_mail_count === $sequenceMailCount
                    ? 'completed'
                    : 'in-progress'
            );
    }
}
