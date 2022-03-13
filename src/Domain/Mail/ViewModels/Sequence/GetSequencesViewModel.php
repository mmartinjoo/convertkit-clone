<?php

namespace Domain\Mail\ViewModels\Sequence;

use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Shared\ViewModels\ViewModel;
use Domain\Mail\DataTransferObjects\PerformanceData;
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
            ->map->getData();
    }

    /**
     * @return Collection<int, PerformanceData>
     */
    public function performances(): Collection
    {
        return Sequence::all()
            ->mapWithKeys(fn (Sequence $sequence) => [
                $sequence->id => $sequence->performance(),
            ]);
    }
}
