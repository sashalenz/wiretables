<?php

namespace Sashalenz\Wiretables\Traits;

use Illuminate\Pagination\Paginator;

trait WithPagination
{
    public int $page = 1;
    public int $perPage = 20;
    public bool $simplePagination = false;
    protected static string $pageKey = 'page';

    public function bootWithPagination(): void
    {
        $this->setPage($this->page);

        Paginator::currentPageResolver(fn () => $this->page);

        Paginator::defaultView($this->paginationView());
        Paginator::defaultSimpleView($this->simplePaginationView());
    }

    public function queryStringWithPagination(): array
    {
        return [
            'page' => [
                'except' => 1,
                'as' => self::$pageKey,
            ],
        ];
    }

    protected function paginationView(): string
    {
        return 'wiretables::partials.pagination';
    }

    protected function simplePaginationView(): string
    {
        return 'wiretables::partials.simple-pagination';
    }

    protected function resetPage(): void
    {
        $this->setPage(1);
    }

    private function setPage($page): void
    {
        $this->page = (int) $page;
    }

    public function gotoPage($page): void
    {
        $this->setPage($page);
    }

    public function previousPage(): void
    {
        if ($this->page === 1) {
            return;
        }

        $this->setPage(--$this->page);
    }

    public function nextPage(): void
    {
        $this->setPage(++$this->page);
    }
}
