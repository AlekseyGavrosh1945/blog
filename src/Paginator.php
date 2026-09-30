<?php

declare(strict_types=1);

namespace App;

class Paginator
{
    public const PER_PAGE = 5;

    private int $total;
    private int $page;

    public function __construct(int $total, int $page = 1)
    {
        $this->total = $total;
        $this->page = max(1, $page);
    }

    public function currentPage(): int
    {
        return min($this->page, $this->totalPages());
    }

    public function totalPages(): int
    {
        return max(1, (int) ceil($this->total / self::PER_PAGE));
    }

    public function limit(): int
    {
        return self::PER_PAGE;
    }

    public function offset(): int
    {
        return ($this->currentPage() - 1) * self::PER_PAGE;
    }

    // номера страниц для навигации: окно из пяти вокруг текущей
    public function pages(): array
    {
        $start = max(1, $this->currentPage() - 2);
        $end = min($this->totalPages(), $this->currentPage() + 2);

        return range($start, $end);
    }
}
