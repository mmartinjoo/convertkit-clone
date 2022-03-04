<?php

namespace Domain\Shared\ValueObjects;

class PaginationData
{
    public readonly int $total;
    public readonly int $current_page;
    public readonly string $next_page_url;
    public readonly string $prev_page_url;

    public function __construct(int $total, int $currentPage, string $baseUrl)
    {
        $this->total = $total;
        $this->current_page = $currentPage;

        $nextPage = $currentPage + 1;
        $prevPage = $currentPage === 1
            ? 1
            : $currentPage - 1;

        $this->next_page_url = "$baseUrl?page={$nextPage}";
        $this->prev_page_url = "$baseUrl?page={$prevPage}";
    }
}
