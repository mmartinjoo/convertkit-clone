<?php

namespace Domain\Subscriber\ViewModels;

use Domain\Shared\ValueObjects\PaginationData;
use Domain\Shared\ViewModels\ViewModel;
use Domain\Subscriber\DataTransferObjects\SubscriberData;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Support\Collection;

class GetSubscribersViewModel extends ViewModel
{
    private const PER_PAGE = 20;

    public function __construct(private readonly int $currentPage)
    {
    }

    /**
     * @return Collection<SubscriberData>
     */
    public function subscribers(): Collection
    {
        return Subscriber::with(['form', 'tags'])
            ->limit(self::PER_PAGE)
            ->offset(self::PER_PAGE * ($this->currentPage - 1))
            ->orderBy('first_name')
            ->get()
            ->map
            ->getData();
    }

    public function pagination(): PaginationData
    {
        return new PaginationData(
            total: Subscriber::count(),
            currentPage: $this->currentPage,
            baseUrl: route('subscribers.index'),
        );
    }
}
