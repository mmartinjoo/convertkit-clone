<?php

namespace Domain\Mail\ViewModels\Sequence;

use Domain\Mail\Actions\GetPerformanceAction;
use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Shared\ViewModels\ViewModel;
use Domain\Statistics\DataTransferObjects\PerformanceData;
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
     * @return Collection<int, PerformanceData>
     */
    public function performances(): Collection
    {
        return Sequence::all()
            ->mapWithKeys(fn (Sequence $sequence) => [
                $sequence->id => GetPerformanceAction::execute($sequence),
            ]);
    }
}
