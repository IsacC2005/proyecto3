<?php

namespace App\DTOs;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaginationDTO
{
    public array $data;
    public array $links;
    public int $total;
    public int $currentPage;
    public int $lastPage;

    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->data = $paginator->items();
        $this->links = $paginator->toArray()['links'];
        $this->total = $paginator->total();
        $this->currentPage = $paginator->currentPage();
        $this->lastPage = $paginator->lastPage();
    }
}
