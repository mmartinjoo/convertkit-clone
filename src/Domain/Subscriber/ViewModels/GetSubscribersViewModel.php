<?php

namespace Domain\Subscriber\ViewModels;

use Domain\Shared\ViewModels\ViewModel;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class GetSubscribersViewModel extends ViewModel
{
    private const PER_PAGE = 20;

    public function __construct(private readonly int $currentPage)
    {
    }

    public function subscribers(): Paginator
    {
        /** @var Collection $items */
        $items = Subscriber::with(['form', 'tags'])
            ->orderBy('first_name')
            ->get()
            ->map
            ->getData();

        $items = $items->slice(self::PER_PAGE * ($this->currentPage - 1));

        return new Paginator(
            $items,
            self::PER_PAGE,
            $this->currentPage,
            [
                'path' => route('subscribers.index'),
            ],
        );
    }

    public function total(): int
    {
        return Subscriber::count();
    }
}
