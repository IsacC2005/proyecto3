<?php

namespace App\DTOs;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaginationDTO
{
    public array $data;
    public array $links;
    public int $total;
    public int $current_page;
    public int $last_page;

    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->data = $paginator->items();
        $this->links = $paginator->toArray()['links'];
        $this->total = $paginator->total();
        $this->current_page = $paginator->currentPage();
        $this->last_page = $paginator->lastPage();
    }
}
