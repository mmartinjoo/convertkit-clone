<?php

namespace Domain\Mail\ViewModels\Broadcast;

use Domain\Mail\DataTransferObjects\Broadcast\BroadcastData;
use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Shared\ViewModels\ViewModel;
use Domain\Mail\DataTransferObjects\PerformanceData;
use Illuminate\Support\Collection;

class GetBroadcastsViewModel extends ViewModel
{
    /**
     * @return Collection<BroadcastData>
     */
    public function broadcasts(): Collection
    {
        return Broadcast::latest()->get()->map->getData();
    }

    /**
     * @return Collection<int, PerformanceData>
     */
    public function performances(): Collection
    {
        return Broadcast::all()
            ->mapWithKeys(fn (Broadcast $broadcast) => [
                $broadcast->id => $broadcast->performance(),
            ]);
    }
}
