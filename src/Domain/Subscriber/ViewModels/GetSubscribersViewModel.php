<?php

namespace Domain\Subscriber\ViewModels;

use Domain\Shared\ViewModels\ViewModel;
use Domain\Subscriber\DataTransferObjects\SubscriberData;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Support\Collection;

class GetSubscribersViewModel extends ViewModel
{
    /**
     * @return Collection<SubscriberData>
     */
    public function subscribers(): Collection
    {
        return Subscriber::with(['form', 'tags'])
            ->latest()
            ->get()
            ->map->getData();
    }
}
