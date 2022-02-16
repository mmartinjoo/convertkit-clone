<?php

namespace Domain\Mail\ViewModels\Broadcast;

use Domain\Mail\Actions\GetPerformanceAction;
use Domain\Mail\DataTransferObjects\Broadcast\BroadcastData;
use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Shared\ViewModels\ViewModel;
use Domain\Statistics\DataTransferObjects\Tracking\TrackingData;
use Illuminate\Support\Collection;

class GetBroadcastsViewModel extends ViewModel
{
    /**
     * @return Collection<BroadcastData>
     */
    public function broadcasts(): Collection
    {
        return Broadcast::latest()->get()->map(fn (Broadcast $broadcast) => BroadcastData::from($broadcast));
    }

    /**
     * @return Collection<int, TrackingData>
     */
    public function performances(): Collection
    {
        return Broadcast::all()
            ->mapWithKeys(fn (Broadcast $broadcast) => [
                $broadcast->id => GetPerformanceAction::execute($broadcast)
            ]);
    }
}
