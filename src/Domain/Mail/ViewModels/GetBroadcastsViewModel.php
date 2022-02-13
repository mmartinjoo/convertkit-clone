<?php

namespace Domain\Mail\ViewModels;

use Domain\Mail\DataTransferObjects\Broadcast\BroadcastData;
use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Shared\ViewModels\ViewModel;
use Illuminate\Support\Collection;

class GetBroadcastsViewModel extends ViewModel
{
    /**
     * @return Collection<BroadcastData>
     */
    public function broadcasts(): Collection
    {
        return Broadcast::all()->map(fn (Broadcast $broadcast) => BroadcastData::from($broadcast));
    }
}
