<?php

namespace Domain\Mail\ViewModels\Sequence;

use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Shared\ViewModels\ViewModel;
use Domain\Statistics\DataTransferObjects\Tracking\TrackingData;
use Illuminate\Support\Collection;

class GetSequencesViewModel extends ViewModel
{
    /**
     * @return Collection<SequenceData>
     */
    public function sequences(): Collection
    {
        return Sequence::query()
            ->with('mails')
            ->latest()
            ->get()
            ->map(fn (Sequence $sequence) => SequenceData::from($sequence));
    }

    /**
     * @return Collection<int, TrackingData>
     */
    public function performances(): Collection
    {
        return Sequence::all()
            ->mapWithKeys(fn (Sequence $sequence) => [
                $sequence->id => $sequence->getPerformance(),
            ]);
    }
}
