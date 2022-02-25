<?php

namespace Domain\Mail\ViewModels\Sequence;

use Domain\Mail\Actions\GetPerformanceAction;
use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Shared\ViewModels\ViewModel;
use Domain\Mail\DataTransferObjects\Sequence\SequenceProgressData;
use Domain\Mail\DataTransferObjects\PerformanceData;
use Illuminate\Support\Collection;

class GetSequenceReportsViewModel extends ViewModel
{
    public function __construct(private readonly Sequence $sequence)
    {
    }

    public function sequence(): SequenceData
    {
        return $this->sequence->getData();
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
        return new SequenceProgressData(
            total: $this->sequence->activeSubscriberCount(),
            in_progress: $this->sequence->inProgressSubscriberCount(),
            completed: $this->sequence->completedSubscriberCount(),
        );
    }
}
